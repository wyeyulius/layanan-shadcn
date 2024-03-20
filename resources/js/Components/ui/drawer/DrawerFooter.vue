<script lang="ts" setup>
import type { HtmlHTMLAttributes } from "vue";
import { cn } from "@/lib/utils";

const props = defineProps<{
    class?: HtmlHTMLAttributes["class"];
}>();
</script>

<template>
    <div
        :class="
            cn(
                'mt-auto mx-auto w-full flex flex-col gap-2 p-4 max-w-sm',
                props.class
            )
        "
    >
        <slot />
    </div>
</template>
