export interface Message {
    id: number;
    body: string;
    sender_id: number;
    created_at: string;
}

export interface User {
    id: number;
    name: string;
    last_seen_at: string | null;
}

