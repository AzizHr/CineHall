<template>
  <div class="grid gap-4 shadow-md pb-6 rounded mx-4">
    <img class="rounded h-fit" src="https://m.media-amazon.com/images/M/MV5BYTRiNDQwYzAtMzVlZS00NTI5LWJjYjUtMzkwNTUzMWMxZTllXkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_.jpg" alt="" />
    <h1 class="font-bold text-xl ml-2">{{ name }}</h1>
    <div class="flex justify-around">
        <h1>{{ rating }}</h1>
        <h1>{{ date }}</h1>
    </div>

    <div class="flex justify-around">
        <h1>{{ price }}</h1>
        <h1>{{ hall_name }}</h1>
    </div>
    <button class="bg-green-500 text-gray-100 px-4 py-2 rounded mx-2">Reserve Now</button>
  </div>
</template>

<script>
export default {
  name: "CardComponent",
  props: ["id", "name" , "image" , "rating" , "date" , "price" , "hall_name"],
};
</script>
