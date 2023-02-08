<template>
  <div class="grid gap-3 rounded mx-4">
    <img class="rounded h-fit" :src="image" alt="" />
    <h1 class="font-bold text-xl">{{ name }}</h1>
    <h1>{{ date }}</h1>
    <button class="bg-red-500 text-gray-100 px-4 py-2 rounded">
      <router-link :to="{ name: 'movie', query: { is: id } }"
        >Book Now</router-link
      >
    </button>
  </div>
</template>

<script>
export default {
  name: "CardComponent",
  props: [
    "id",
    "name",
    "image",
    "rating",
    "date",
    "year",
    "price",
    "hall_name",
  ],
  methods: {},
};
</script>
