<template>
  <div>
    <div
      class="relative h-screen bg-no-repeat bg-cover bg-black"
    >
      
      <div class="absolute top-0 left-0 bottom-0">
        <h1 class="text-white md:text-5xl text-2xl md:ml-24 ml-10 mt-32">
          {{ movie.title }}
        </h1>
        <div class="flex gap-6 items-center md:ml-28 ml-14 md:pt-8 pt-4">
          <div class="flex gap-2">
            <h1 class="text-white md:text-4xl text-2xl">{{ movie.rating }}</h1>
            <img class="w-8 h-8" src="../assets/star.png" alt="" />
          </div>
          <h1 class="text-white md:text-2xl text-xl">
            {{ movie.released_at }}
          </h1>
        </div>
        <div class="flex gap-44">
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
        v-for="n in 40"
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
        Presented in {{ movie.name }} at {{ movie.shown_at }}
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
    if (!this.client_ref) {
      window.location = "http://localhost:8080/login";
    }
    axios
      .get(`http://localhost/CineHall/api/movies/show/${this.$route.query.id}`)
      .then((res) => (this.movie = res.data));

    this.updateRes();
  },
  data() {
    return {
      movie: "",
      reservedSeats: [],
      client_ref: localStorage.getItem("client_ref"),
      client_name: localStorage.getItem("client_name"),
    };
  },
  methods: {
    updateRes() {
      axios
        .get(
          `http://localhost/CineHall/api/movies/reserved_seats/${this.$route.query.id}`
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
        formdata.append("hall_id_fk", this.movie.hall_id_fk);
        formdata.append("client_id_fk", this.client_ref);
        formdata.append("movie_id_fk", this.movie.movie_id_fk);
        formdata.append("seat_number", this.getChecked());
        axios({
          url: "http://localhost/CineHall/api/clients/book",
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
            this.updateRes();
          })
          .catch((err) => {
            // on error
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: `${res.data.Error}`,
            });
          });
      } else {
        Swal.fire({
          icon: "error",
          title: "Done!",
          text: "Please Select a Seat First",
        });
      }
    },
    logout() {
      localStorage.clear();
    },
  },
};
</script>
