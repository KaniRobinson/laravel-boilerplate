<script setup lang="ts">
import { index as chatsIndex, show as chatsShow } from '@/routes/chats';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import type { User } from '@/types/chat';
import AppLayout from '@/layouts/AppLayout.vue';
import AlertError from '@/components/AlertError.vue';
import Avatar from '@/components/ui/avatar/Avatar.vue';
import AvatarImage from '@/components/ui/avatar/AvatarImage.vue';
import AvatarFallback from '@/components/ui/avatar/AvatarFallback.vue';

defineProps<{
    users: User[];
    presence_channel: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Chats', href: chatsIndex().url },
];
</script>

<template>
    <Head title="Chats" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-b-xl">
            <!-- No users available yet -->
            <div v-if="users.length === 0" class="p-4">
                <AlertError :errors="['No other users available yet. Invite someone so you can start a conversation.']" title="There are no other users available yet." />
            </div>

            <!-- Users list -->
             <div v-else class="divide-y">
                <Link v-for="user in users" :key="user.id" :href="chatsShow(user).url" class="flex items-center gap-4 px-4 py-3 transition hover:bg-muted/60">
                    <Avatar>
                        <AvatarImage :src="`https://api.dicebear.com/9.x/initials/svg?seed=${encodeURIComponent(user.name)}`" :alt="user.name" />
                        <AvatarFallback>{{ user.name.slice(0, 2).toUpperCase() }}</AvatarFallback>
                    </Avatar>
                    <div class="grid flex-1 text-left text-sm leading-tight">
                        <span class="truncate font-medium">{{ user.name }}</span>
                    </div>
                    <div class="text-xs text-muted-foreground text-right">
                        {{ user.last_seen_at ? new Date(user.last_seen_at).toLocaleString() : 'Never' }}
                    </div>
                </Link>
             </div>
        </div>
    </AppLayout>
</template>
