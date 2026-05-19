import { Redis } from '@upstash/redis';
import { env } from './env';

const redis = new Redis({
  url: env.UPSTASH_REDIS_REST_URL,
  token: env.UPSTASH_REDIS_REST_TOKEN,
});

const limits: Record<string, number | null> = {
  free: 20,
  pro: 500,
  team: null,
};

export async function checkRateLimit(userId: string, plan: string) {
  const limit = limits[plan] ?? limits.free;
  if (limit === null) return { allowed: true, remaining: null };

  const key = `vaultai:rate:${userId}:${new Date().toISOString().slice(0, 10)}`;
  const count = await redis.incr(key);
  if (count === 1) {
    await redis.expire(key, 60 * 60 * 24);
  }
  return {
    allowed: count <= limit,
    remaining: Math.max(limit - count, 0),
    used: count,
    limit,
  };
}
