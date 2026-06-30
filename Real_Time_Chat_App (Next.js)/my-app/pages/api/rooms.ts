import type { NextApiRequest, NextApiResponse } from "next";
import { getRooms } from "../../lib/chatStore";

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method !== "GET") {
    res.status(405).json({ error: "Method not allowed" });
    return;
  }

  const rooms = await getRooms();
  res.status(200).json({ rooms });
}
