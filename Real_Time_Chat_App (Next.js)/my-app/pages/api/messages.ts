import type { NextApiRequest, NextApiResponse } from "next";
import { getMessages } from "../../lib/chatStore";

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method !== "GET") {
    res.status(405).json({ error: "Method not allowed" });
    return;
  }

  const room = typeof req.query.room === "string" ? req.query.room : "general";
  const messages = await getMessages(room);
  res.status(200).json({ messages });
}
