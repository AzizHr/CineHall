<template>
  <div>
    <div class="home bg-cover bg-center bg-no-repeat h-screen">
      <NavbarComponent v-if="!client_ref" />

      <nav
        v-if="client_ref"
        class="border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-900"
      >
        <div
          class="container flex flex-wrap items-center justify-between mx-auto"
        >
          <a href="http://localhost:8080/" class="flex items-center">
            <img src="../assets/popcorn.png" class="h-6 mr-3 sm:h-9" alt="" />
            <span
              class="self-center text-xl font-semibold whitespace-nowrap text-white"
              >CineHall</span
            >
          </a>
          <button
            data-collapse-toggle="navbar-default"
            type="button"
            class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default"
            aria-expanded="false"
          >
            <span class="sr-only">Open main menu</span>
            <svg
              class="w-6 h-6"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
              class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg backdrop-blur-sm bg-white/10 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
            >
              <li>
                <a
                  class="block py-2 pl-3 pr-4 text-red-600 rounded md:bg-transparent md:p-0 dark:text-white"
                  ><router-link to="/">Home</router-link></a
                >
              </li>
              <li>
                <a
                  class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                  ><router-link to="/my-reservations"
                    >My Reservations</router-link
                  ></a
                >
              </li>
              <li>
                <a
                  class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                  ><router-link to="/">{{ client_name }}</router-link></a
                >
              </li>
              <li>
                <a
                  href=""
                  class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                  @click="logout()"
                  >Logout</a
                >
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <h1
        class="md:text-5xl text-xl text-gray-100 mt-32 md:ml-10 ml-20 md:w-1/2 leading-relaxed"
      >
        <span class="text-red-600 font-bold">CINEHALL </span> THE PLACE OF
        ENTERTAINMENT
      </h1>
    </div>
    <h1 class="md:text-4xl text-2xl md:ml-16 ml-8 md:mt-20 mt-10 font-bold">
      <input
        class="py-1 px-6 border-2 border-red-400 rounded text-lg"
        type="date"
        v-model="date"
        @change="filter()"
      />
    </h1>
    <h1 class="text-gray-900 text-2xl text-center font-bold pb-12" v-if="!movies.length">No Movies Found</h1>
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 justify-items-center gap-4 mt-16 pb-12"
      v-if="movies.length"
    >
      <CardComponent
        v-for="movie in movies"
        v-bind:key="movie.movie_id"
        :title="movie.title"
        :movie_id="movie.movie_id"
        :image="movie.image"
        :thumbnail="movie.thumbnail"
        :rating="movie.rating"
        :name="movie.name"
        :shown_at="movie.shown_at"
      />
    </div>
    </div>
</template>

<script>
import NavbarComponent from "@/components/NavbarComponent.vue";
import CardComponent from "@/components/CardComponent.vue";
import axois from "axios";
export default {
  name: "HomeView",
  components: {
    NavbarComponent,
    CardComponent,
  },
  data() {
    return {
      movies: [],
      date: "",
      client_ref: localStorage.getItem("client_ref"),
      client_name: localStorage.getItem("client_name"),
    };
  },
  methods: {
    logout() {
      localStorage.clear();
    },
    filter() {
      axois
        .get(`http://localhost/CineHall/api/movies/filter/${this.date}`)
        .then((res) => {
          this.movies = res.data;
        });
    },
  },
  mounted() {
    axois.get("http://localhost/CineHall/api/movies").then((res) => {
      this.movies = res.data;
    });
    // this.filter()
  },
};
</script>

<script></script>

<style scoped>
.home {
  background-image: url("../assets/home_main_image.jpg");
}
</style>
