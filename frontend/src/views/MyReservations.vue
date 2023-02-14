<template>
  <div class="myRes bg-cover bg-center bg-no-repeat h-screen px-5">
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
            class="flex flex-col p-4 mt-4 bg-gray-500 border border-gray-100 rounded-lg backdrop-blur-sm bg-white/10 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
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
    <h1 class="text-center underline text-blue-700 mt-44" v-if="!user_ref">
      <router-link to="/login">LOGIN TO SEE THIS</router-link>
    </h1>
    <div v-if="user_ref">
      <h1 class="text-gray-200 text-3xl text-center font-bold">
        MY RESERVATIONS :
      </h1>
      <div class="relative overflow-x-auto pt-6">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">RESERVED AT</th>
              <th scope="col" class="px-6 py-3">HALL NAME</th>
              <th scope="col" class="px-6 py-3">SEAT NUMBER</th>
              <th scope="col" class="px-6 py-3">SHOWED AT</th>
              <th scope="col" class="px-6 py-3">CANCEL</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr
              v-for="my_res in my_reservations"
              :key="my_res.id"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ my_res.reserved_at }}
              </th>
              <td class="px-6 py-4">{{ my_res.hall_name }}</td>
              <td class="px-6 py-4">{{ my_res.seat_number }}</td>
              <td class="px-6 py-4">{{ my_res.showed_at }}</td>
              <td class="px-6 py-4">
                <button
                  @click="cancel(my_res.id)"
                  class="py-2 px-4 bg-red-500 text-gray-200 font-bold"
                >
                  cancel
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import NavbarComponent from "@/components/NavbarComponent.vue";
export default {
  name: "MyReservations",
  components: {
    NavbarComponent,
  },
  mounted() {
    this.getUserReservations();
  },
  data() {
    return {
      user_ref: localStorage.getItem("user_ref"),
      user_name: localStorage.getItem("user_name"),
      my_reservations: [],
    };
  },
  methods: {
    getUserReservations() {
      const formdata = new FormData();
      formdata.append("user_ref", this.user_ref);
      axios({
        url: "http://localhost/CineHall/Backend/users/my_reservations",
        method: "post",
        data: formdata,
      })
        .then((res) => {
          this.my_reservations = res.data;
        })
        .catch((err) => {
          console.log(err.data);
        });
    },
    logout() {
      localStorage.clear();
    },
    cancel(reservation) {
      axios
        .post(`http://localhost/CineHall/Backend/users/delete/${reservation}`)
        .then((res) => {
          // Swal.fire({
          //   icon: "success",
          //   title: "Done!",
          //   text: `${res.data}`,
          // });
          console.log(res.data);
        })
        .catch((err) => {
          // Swal.fire({
          //   icon: "success",
          //   title: "Done!",
          //   text: `${err.data.Error}`,
          // });
          console.log(err.data);
        });
    },
  },
};
</script>

<style scoped>
.myRes {
  background-image: url("../assets/myres.jpg");
}
</style>
