import type { NextApiRequest, NextApiResponse } from "next";
import { WebSocketServer } from "ws";
import type { WebSocket } from "ws";
import type { Server as HTTPServer } from "http";
import type { Socket } from "net";
import { saveMessage } from "../../lib/chatStore";

type NextApiResponseServerIO = NextApiResponse & {
  socket: Socket & {
    server: HTTPServer & {
      ws?: WebSocketServer;
    };
  };
};

type ServerMessage = {
  id: string;
  type: "message" | "system" | "typing";
  username?: string;
  text?: string;
  createdAt: string;
  room?: string;
  userId?: string | null;
};

type ClientPayload = {
  type: "message" | "typing" | "join" | "leave";
  room?: string;
  username?: string;
  userId?: string | null;
  text?: string;
};

type ClientState = {
  room: string;
  username: string;
  userId?: string | null;
};

const roomClients = new Map<string, Set<WebSocket>>();
const clientState = new Map<WebSocket, ClientState>();

const normalizeRoom = (roomName?: string) => (roomName?.trim() || "general").toLowerCase();

const broadcast = (roomName: string, data: ServerMessage, exclude?: WebSocket) => {
  const payload = JSON.stringify(data);
  const clients = roomClients.get(normalizeRoom(roomName)) ?? new Set<WebSocket>();

  clients.forEach((client) => {
    if (client !== exclude && client.readyState === client.OPEN) {
      client.send(payload);
    }
  });
};

const joinRoom = (socket: WebSocket, roomName: string, username: string, userId?: string | null) => {
  const normalizedRoom = normalizeRoom(roomName);
  const previousRoom = clientState.get(socket)?.room;

  if (previousRoom && previousRoom !== normalizedRoom) {
    const previousClients = roomClients.get(previousRoom);
    previousClients?.delete(socket);
    if (previousClients?.size === 0) {
      roomClients.delete(previousRoom);
    }
  }

  if (!roomClients.has(normalizedRoom)) {
    roomClients.set(normalizedRoom, new Set());
  }
  roomClients.get(normalizedRoom)?.add(socket);
  clientState.set(socket, { room: normalizedRoom, username, userId });

  const welcomeMessage: ServerMessage = {
    id: `${Date.now()}-join`,
    type: "system",
    text: `${username || "Someone"} joined ${normalizedRoom}`,
    createdAt: new Date().toISOString(),
    room: normalizedRoom,
    userId,
  };

  broadcast(normalizedRoom, welcomeMessage);
};

const handler = (req: NextApiRequest, res: NextApiResponseServerIO) => {
  if (req.method !== "GET") {
    res.status(405).end();
    return;
  }

  if (!res.socket.server.ws) {
    const wss = new WebSocketServer({ noServer: true });
    res.socket.server.ws = wss;

    wss.on("connection", (socket: WebSocket) => {
      socket.on("message", async (raw: Buffer) => {
        try {
          const data = JSON.parse(raw.toString()) as ClientPayload;

          if (data.type === "join") {
            joinRoom(socket, data.room || "general", data.username || "Guest", data.userId);
            return;
          }

          const state = clientState.get(socket);
          if (!state) {
            joinRoom(socket, data.room || "general", data.username || "Guest", data.userId);
            return;
          }

          if (data.type === "typing") {
            const typingMessage: ServerMessage = {
              id: `${Date.now()}-typing`,
              type: "typing",
              username: data.username || state.username,
              createdAt: new Date().toISOString(),
              room: state.room,
              userId: data.userId ?? state.userId,
            };
            broadcast(state.room, typingMessage, socket);
            return;
          }

          if (data.type === "message" && data.text) {
            const message = await saveMessage({
              room: state.room,
              username: data.username || state.username,
              text: data.text,
              userId: data.userId ?? state.userId,
            });

            const chatMessage: ServerMessage = {
              id: message.id,
              type: "message",
              username: message.username,
              text: message.text,
              createdAt: message.createdAt,
              room: message.room,
              userId: message.userId,
            };
            broadcast(state.room, chatMessage);
          }
        } catch {
          // ignore malformed payloads
        }
      });

      socket.on("close", () => {
        const state = clientState.get(socket);
        if (!state) {
          return;
        }

        const roomClientsForState = roomClients.get(state.room);
        roomClientsForState?.delete(socket);
        if (roomClientsForState?.size === 0) {
          roomClients.delete(state.room);
        }
        clientState.delete(socket);
      });
    });

    res.socket.server.on("upgrade", (request, socket: Socket, head: Buffer) => {
      if (request.url === "/api/socket") {
        wss.handleUpgrade(request, socket, head, (ws: WebSocket) => {
          wss.emit("connection", ws, request);
        });
      } else {
        socket.destroy();
      }
    });
  }

  res.status(200).end();
};

export default handler;
