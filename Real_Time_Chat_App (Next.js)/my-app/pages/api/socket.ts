import type { NextApiRequest, NextApiResponse } from "next";
import { WebSocketServer } from "ws";
import type { WebSocket } from "ws";
import type { Server as HTTPServer } from "http";
import type { Socket } from "net";

type NextApiResponseServerIO = NextApiResponse & {
  socket: Socket & {
    server: HTTPServer & {
      ws?: WebSocketServer;
    };
  };
};

type ServerMessage = {
  id: string;
  type: "message" | "system";
  username?: string;
  text: string;
  createdAt: string;
};

const broadcast = (wss: WebSocketServer, data: ServerMessage) => {
  const payload = JSON.stringify(data);
  wss.clients.forEach((client: WebSocket) => {
    if (client.readyState === client.OPEN) {
      client.send(payload);
    }
  });
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
      const joinMessage: ServerMessage = {
        id: `${Date.now()}-join`,
        type: "system",
        text: "A participant joined the room.",
        createdAt: new Date().toISOString(),
      };
      broadcast(wss, joinMessage);

      socket.on("message", (raw: Buffer) => {
        try {
          const data = JSON.parse(raw.toString()) as Partial<ServerMessage>;
          if (!data.type || data.type !== "message" || !data.username || !data.text) {
            return;
          }

          const chatMessage: ServerMessage = {
            id: `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
            type: "message",
            username: data.username,
            text: data.text,
            createdAt: new Date().toISOString(),
          };
          broadcast(wss, chatMessage);
        } catch {
          // ignore malformed messages
        }
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
