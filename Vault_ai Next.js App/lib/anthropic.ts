import { AnthropicClient } from '@anthropic-ai/sdk';
import { env } from './env';

const client = new AnthropicClient({ apiKey: env.ANTHROPIC_API_KEY });

export async function askClaude(prompt: string, context: string) {
  const response = await client.responses.create({
    model: env.ANTHROPIC_MODEL,
    input: `You are VaultAI. Use the document context to answer the user question.

Document context:
${context}

Question:
${prompt}

Answer:`,
    max_tokens_to_sample: 1200,
    temperature: 0.15,
    stream: false,
  });

  return response.output[0]?.content?.[0]?.text ?? 'Sorry, I could not process that request.';
}
