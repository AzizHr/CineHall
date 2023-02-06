<template>
  <div>
    <div class="home bg-cover bg-center bg-no-repeat h-screen">
      <NavbarComponent />
      <h1
        class="md:text-5xl text-xl text-gray-100 mt-32 md:ml-10 ml-20 md:w-1/2 leading-relaxed"
      >
        <span class="text-red-600 font-bold">CINEHALL </span> THE PLACE OF
        ENTERTAINMENT
      </h1>
    </div>
    <h1 class="md:text-4xl text-2xl md:ml-16 ml-8 md:mt-20 mt-10 font-bold">
      Availabe Movies This Week
    </h1>
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 justify-items-center gap-4 mt-16"
    >
      <CardComponent
        v-for="movie in movies"
        v-bind:key="movie.id"
        :name="movie.name"
        :id="movie.id"
        :image="movie.image"
        :rating="movie.rating"
        :date="movie.year"
        :price="movie.price"
        :hall_name="movie.hall_name"
      />
    </div>
  </div>
</template>

<script>
import NavbarComponent from "@/components/NavbarComponent.vue";
import HeroComponent from "@/components/HeroComponent.vue";
import CardComponent from "@/components/CardComponent.vue";
import axois from "axios";
export default {
  name: "HomeView",
  components: {
    NavbarComponent,
    HeroComponent,
    CardComponent,
  },
  data() {
    return {
      movies: "",
    };
  },
  components: {
    CardComponent,
    NavbarComponent,
  },
  mounted() {
    axois.get("http://localhost/CineHall/Backend/movies/movies").then((res) => {
      this.movies = res.data;
    });
  },
};
</script>

<style scoped>
.home {
  background-image: url("../assets/home_main_image.jpg");
}
</style>
