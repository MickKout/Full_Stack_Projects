import { useCallback, useEffect, useRef, useState } from "react";

export type ChatMessage = {
  id: string;
  type: "message" | "system";
  username?: string;
  text: string;
  createdAt: string;
  room?: string;
  userId?: string | null;
};

export type ChatRoom = {
  id: string;
  name: string;
};

type SocketPayload = {
  type: "message" | "typing" | "system" | "join" | "leave";
  room?: string;
  username?: string;
  userId?: string | null;
  text?: string;
  id?: string;
  createdAt?: string;
};

const getSocketUrl = () => {
  const protocol = window.location.protocol === "https:" ? "wss" : "ws";
  return `${protocol}://${window.location.host}/api/socket`;
};

export function useSocket(room: string, username: string, userId: string) {
  const [messages, setMessages] = useState<ChatMessage[]>([]);
  const [rooms, setRooms] = useState<ChatRoom[]>([]);
  const [status, setStatus] = useState("Connecting...");
  const [typingUsers, setTypingUsers] = useState<string[]>([]);
  const socketRef = useRef<WebSocket | null>(null);
  const typingTimer = useRef<number | null>(null);
  const usernameRef = useRef(username);

  useEffect(() => {
    usernameRef.current = username;
  }, [username]);

  useEffect(() => {
    let active = true;

    const loadInitialState = async () => {
      try {
        const [roomsResponse, messagesResponse] = await Promise.all([
          fetch("/api/rooms"),
          fetch(`/api/messages?room=${encodeURIComponent(room)}`),
        ]);

        const roomsData = await roomsResponse.json();
        const messagesData = await messagesResponse.json();

        if (!active) return;
        setRooms(roomsData.rooms ?? []);
        setMessages(messagesData.messages ?? []);
      } catch {
        if (active) {
          setRooms([{ id: room, name: room }]);
          setMessages([]);
        }
      }
    };

    loadInitialState();
    return () => {
      active = false;
    };
  }, [room]);

  useEffect(() => {
    const socket = new WebSocket(getSocketUrl());
    socketRef.current = socket;

    socket.addEventListener("open", () => {
      setStatus("Connected");
      socket.send(
        JSON.stringify({
          type: "join",
          room,
          username: usernameRef.current || "Guest",
          userId,
        })
      );
    });

    socket.addEventListener("message", (event) => {
      try {
        const payload = JSON.parse(event.data) as SocketPayload;

        if (payload.type === "message" || payload.type === "system") {
          const message = {
            id: payload.id ?? `${Date.now()}`,
            type: payload.type,
            username: payload.username,
            text: payload.text ?? "",
            createdAt: payload.createdAt ?? new Date().toISOString(),
            room: payload.room,
            userId: payload.userId ?? undefined,
          } as ChatMessage;
          setMessages((current) => [...current, message]);
          return;
        }

        if (payload.type === "typing") {
          const otherName = payload.username;
          if (!otherName || otherName === usernameRef.current) return;
          setTypingUsers((current) => (current.includes(otherName) ? current : [...current, otherName]));
          window.setTimeout(() => {
            setTypingUsers((current) => current.filter((value) => value !== otherName));
          }, 1200);
        }
      } catch {
        // ignore malformed payloads
      }
    });

    socket.addEventListener("close", () => {
      setStatus("Disconnected");
    });

    socket.addEventListener("error", () => {
      setStatus("Connection error");
    });

    return () => {
      socket.close();
    };
  }, [room, userId]);

  const sendMessage = useCallback(
    (text: string) => {
      const socket = socketRef.current;
      if (!socket || socket.readyState !== WebSocket.OPEN) return false;

      const messageText = text.trim();
      if (!messageText) return false;

      socket.send(
        JSON.stringify({
          type: "message",
          room,
          username: usernameRef.current || "Guest",
          userId,
          text: messageText,
        })
      );
      return true;
    },
    [room, userId]
  );

  const sendTyping = useCallback(
    (isTyping: boolean) => {
      const socket = socketRef.current;
      if (!socket || socket.readyState !== WebSocket.OPEN) return;

      if (!isTyping) {
        if (typingTimer.current) {
          window.clearTimeout(typingTimer.current);
          typingTimer.current = null;
        }
        return;
      }

      if (typingTimer.current) {
        window.clearTimeout(typingTimer.current);
      }

      socket.send(
        JSON.stringify({
          type: "typing",
          room,
          username: usernameRef.current || "Guest",
          userId,
        })
      );

      typingTimer.current = window.setTimeout(() => {
        sendTyping(false);
      }, 1200);
    },
    [room, userId]
  );

  useEffect(() => {
    return () => {
      if (typingTimer.current) {
        window.clearTimeout(typingTimer.current);
      }
    };
  }, []);

  return {
    messages,
    rooms,
    status,
    typingUsers,
    sendMessage,
    sendTyping,
  };
}
