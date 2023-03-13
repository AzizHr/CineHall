<template>
  <div class="grid gap-3 rounded mx-4">
    <img
      class="rounded h-fit"
      :src="image"
      alt=""
    />
    <h1 class="font-bold text-xl">{{ title }}</h1>
    <h1>Shown at : {{ shown_at }}</h1>
    <h1>In {{ name }}</h1>
    <button class="bg-red-500 text-gray-100 px-4 py-2 rounded">
      <router-link :to="{ name: 'movie', query: { id: shown_at } }"
        >Book Now</router-link
      >
    </button>
  </div>
</template>

<script>
export default {
  name: "CardComponent",
  props: ["movie_id", "title", "image", "rating", "name", "shown_at", "thumbnail", "year", "trailer"],
  methods: {},
};
</script>
