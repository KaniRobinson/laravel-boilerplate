<script setup lang="ts">
import { index as chatsIndex } from '@/routes/chats';
import { type BreadcrumbItem } from '@/types';
import type { User, Message } from '@/types/chat';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { nextTick, onMounted, ref } from 'vue';
import { useEchoPresence } from '@laravel/echo-vue';

const props = defineProps<{
    user: User;
    messages: Message[];
    presence_channel: string,
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Chats', href: chatsIndex().url },
    { title: props.user.name, href: '#' },
];

const participants = ref<User[]>([]);

const messages = ref<Message[]>(props.messages);

const { channel } = useEchoPresence(props.presence_channel, [], () => {});

const form = useForm({
    body: '',
});

onMounted(() => {
    window.scrollTo({
        behavior: 'smooth',
        top: document.documentElement.scrollHeight,
    }); 

    channel()
        .here(onParticipantsHere)
        .joining(onParticipantJoined)
        .leaving(onParticipantLeft)
        .listen('.chat.message.sent', onMessageReceived);
})

function onParticipantsHere(users: User[]) {
    participants.value = users;
}

function onParticipantJoined(user: User) {
    participants.value.push(user);
}

function onParticipantLeft(user: User) {
    participants.value = participants.value.filter((u) => u.id !== user.id);
}

function onMessageSent() {
    form.post(`/chats/${props.user.id}`, {
        preserveScroll: true,
        onSuccess: () => form.reset('body'),
    });
}

function onMessageReceived(message: Message) {
    messages.value.push(message);

    nextTick(() => window.scrollTo({
        behavior: 'smooth',
        top: document.documentElement.scrollHeight,
    }));
}
</script>

<template>
    <Head :title="`Chat with ${user.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="gap-4 flex h-full flex-1 flex-col bg-muted rounded-b-xl">
            <div class="flex flex-col gap-4 flex-1 max-w-3xl w-full mx-auto py-6">
                <div v-for="message in messages" :key="message.id" class="flex flex-col gap-2 px-4">
                    <div :class="message.sender_id === $page.props.auth.user.id ? 'bg-primary text-primary-foreground self-end' : 'bg-background text-foreground self-start'" class="p-4 max-w-[65%] rounded-xl text-sm leading-normal whitespace-pre-line">
                        {{ message.body }}
                    </div>
                </div>
            </div>

            <div class="max-w-3xl w-full mx-auto px-4">
                <form class="flex items-center gap-3 py-3 px-6 mx-auto mb-4 bg-background rounded-full" @submit.prevent="onMessageSent">
                    <input
                        v-model="form.body"
                        placeholder="Send a message..."
                        class="flex-1 appearance-none focus:outline-none"
                        :disabled="form.processing"
                        required
                    />
                </form>
            </div>
        </div>
    </AppLayout>
</template>
