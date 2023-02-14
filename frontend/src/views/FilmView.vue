<template>
  <div>
    <div
      class="relative h-screen bg-no-repeat bg-cover"
      :style="{ backgroundImage: `url(${movie.image})` }"
    >
      <NavbarComponent v-if="!user_ref" />

      <nav
        v-if="user_ref"
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
                  ><router-link to="/films">Films</router-link></a
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
                  ><router-link to="/">{{ user_name }}</router-link></a
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
      <div class="absolute top-0 left-0 bottom-0">
        <h1 class="text-white md:text-5xl text-2xl md:ml-24 ml-10 mt-32">
          {{ movie.title }}
        </h1>
        <div class="flex gap-6 items-center md:ml-28 ml-14 md:pt-8 pt-4">
          <div class="flex gap-2">
            <h1 class="text-white md:text-4xl text-2xl">{{ movie.rating }}</h1>
            <img class="w-8 h-8" src="../assets/star.png" alt="" />
          </div>
          <h1 class="text-white md:text-2xl text-xl">{{ movie.year }}</h1>
        </div>
        <div class="flex gap-52">
          <p class="text-white w-1/3 md:ml-24 md:pt-8 md:block hidden">
            {{ movie.description }}
          </p>
          <iframe
            class="rounded ring-2 ring-outset ml-10 md:mt-1 mt-10 md:w-100 md:h-52 w-80 h-38"
            :src="movie.trailer"
          >
          </iframe>
        </div>
      </div>
    </div>
    <div
      class="grid justify-items-center grid-cols-6 gap-2 mt-10 w-1/2 mx-auto pb-10"
    >
      <input
        v-for="n in 30"
        :key="n"
        type="checkbox"
        :checked="reservedSeats.includes(n)"
        :disabled="reservedSeats.includes(n)"
        :value="n"
        name="seat_number"
        class="w-12 h-12 seat"
      />
    </div>

    <div
      class="flex justify-center justify-between gap-6 items-center w-1/2 mx-auto mb-10"
    >
      <button
        class="bg-red-500 hover:bg-red-600 hover:text-gray-300 text-gray-200 md:px-8 px-4 md:py-3 py-2 rounded md:font-bold md:ring-2 ring-red-300"
        @click="book()"
      >
        Book
      </button>
      <p class="md:text-xl">
        Presented in
        <span class="text-red-500 font-bold">{{ movie.hall_name }}</span>
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import NavbarComponent from "@/components/NavbarComponent.vue";
export default {
  name: "FilmView",
  components: {
    NavbarComponent,
  },
  mounted() {
    axios
      .get(
        `http://localhost/CineHall/Backend/movies/movie_info/${this.$route.query.is}`
      )
      .then((res) => (this.movie = res.data));
    this.updateRes();
  },
  data() {
    return {
      movie: "",
      reservedSeats: [],
      user_ref: localStorage.getItem("user_ref"),
      user_name: localStorage.getItem("user_name"),
    };
  },
  methods: {
    updateRes() {
      axios
        .get(
          `http://localhost/CineHall/Backend/movies/reserved_seats/${this.$route.query.is}`
        )
        .then((res) => (this.reservedSeats = res.data));
    },
    getChecked() {
      let seats = document.getElementsByClassName("seat");
      let checked_seat;
      for (let i = 0; i < seats.length; i++) {
        if (seats[i].checked && !seats[i].disabled) {
          checked_seat = parseInt(seats[i].value);
        }
      }
      return checked_seat;
    },
    book() {
      if (this.getChecked() !== null && this.getChecked() > 0) {
        const formdata = new FormData();
        formdata.append("hall_id", this.movie.hall_id);
        formdata.append("user_ref", "b59ce932");
        formdata.append("showed_at", this.movie.date);
        formdata.append("seat_number", this.getChecked());
        axios({
          url: "http://localhost/CineHall/Backend/users/reserve",
          method: "post",
          data: formdata,
        })
          .then((res) => {
            // after sucess
            Swal.fire({
              icon: "success",
              title: "Done!",
              text: `${res.data.Success}`,
            });
            // console.log(res.data)
            this.updateRes();
          })
          .catch((err) => {
            // on error
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: `${res.data.Error}`,
            });
            // console.log(err.data)
          });
      } else {
        Swal.fire({
          icon: "error",
          title: "Done!",
          text: "Please Select a Seat First",
        });
        // console.log('Please Select a Seat First')
      }
    },
    logout() {
      localStorage.clear();
    },
  },
};
</script>
