export interface VaultDocument {
  id: string;
  userId: string;
  name: string;
  url: string;
  extractedText: string;
  createdAt: string;
}

export interface ConversationMessage {
  id: string;
  conversationId: string;
  role: 'user' | 'assistant';
  content: string;
  createdAt: string;
}
