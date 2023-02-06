<template>
  <div class="relative md:h-full h-screen">
    <img :src="movie.image" class="object-fill h-full w-full" alt="" />
    <div class="absolute top-0 left-0 bottom-0">
      <h1 class="text-white md:text-5xl text-2xl md:ml-24 ml-10 mt-32">
        {{movie.title}}
      </h1>
      <div class="flex gap-6 items-center md:ml-28 ml-14 md:pt-8 pt-4">
        <div class="flex gap-2">
          <h1 class="text-white md:text-4xl text-2xl">{{ movie.rating }}</h1>
          <img class="w-8 h-8" src="../assets/star.png" alt="" />
        </div>
        <h1 class="text-white md:text-2xl text-xl">{{ movie.year }}</h1>
      </div>
      <p class="text-white w-1/3 md:ml-24 md:pt-8 md:block hidden">
        {{ movie.description }}
      </p>
      <form>
        <div
          class="md:flex grid md:gap-52 gap-6 items-center md:mt-24 mt-16 md:ml-24 ml-10"
        >
          <div class="grid gap-4">
            <button
              class="bg-red-500 hover:bg-red-600 hover:text-gray-300 text-gray-200 md:px-8 px-4 md:py-3 py-2 rounded md:font-bold md:ring-2 ring-red-300"
            >
              Book
            </button>
            <select class="border py-2 pl-1 w-52 rounded">
              <option value="1">1</option>
            </select>
          </div>
          <p class="text-white md:text-xl">
            Presented in <span class="text-red-500 font-bold">{{ movie.hall_name }}</span>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "FilmView",
  mounted() {
    axios
      .get(
        `http://localhost/CineHall/Backend/movies/movie_info/${this.$route.query.is}`
      )
      .then((res) => (this.movie = res.data));
  },
  data() {
    return {
      movie: {},
    };
  },
};
</script>

<style scoped>
/* .login {
      background-image: url('../assets/film1.jpg');
    } */
</style>
