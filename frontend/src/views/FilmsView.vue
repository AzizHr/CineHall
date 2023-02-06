<template>
  <div class="films">
    <NavbarComponent />
    <h1 class="text-center mt-12">This is Films page</h1>
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 justify-items-center gap-4 mt-16"
    >
      <CardComponent
        v-for="film in films"
        v-bind:key="film.id"
        :name="film.name"
        :id="film.id"
        :image="film.image"
        :rating="film.rating"
        :date="film.date"
        :price="film.price"
        :hall_name="film.hall_name"
      />
    </div>
  </div>
    
</template>

<script>
import CardComponent from "@/components/CardComponent.vue";
import NavbarComponent from "@/components/NavbarComponent.vue";
import axois from "axios";
export default {
  name: "FilmsView",
  data() {
    return {
      films: "",
    };
  },
  components: {
    CardComponent,
    NavbarComponent,
  },
  mounted() {
    axois.get("http://localhost/CineHall/Backend/films/films").then((res) => {
      this.films = res.data;
    });
  },
};
</script>
