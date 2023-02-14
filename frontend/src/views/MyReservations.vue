<template>
  <div class="myRes bg-cover bg-center bg-no-repeat h-screen px-5 pt-10">
    <h1 class="text-gray-200 text-3xl text-center font-bold">
      MY RESERVATIONS :
    </h1>
    <div class="relative overflow-x-auto pt-6">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">RESERVED AT</th>
            <th scope="col" class="px-6 py-3">HALL NAME</th>
            <th scope="col" class="px-6 py-3">SEAT NUMBER</th>
            <th scope="col" class="px-6 py-3">CANCEL</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr v-for="my_res in my_reservations" :key="my_res.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >{{ my_res.reserved_at }}</th>
            <td class="px-6 py-4">{{ my_res.hall_name}}</td>
            <td class="px-6 py-4">{{ my_res.seat_number }}</td>
            <td class="px-6 py-4"><button class="py-2 px-4 bg-red-500 text-gray-200 font-bold">cancel</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "MyReservations",
  mounted() {
    this.getUserReservations()
  },
  data() {
    return {
      user_ref: localStorage.getItem("user_ref"),
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
      }).then((res) => {
        this.my_reservations = res.data
      }).catch((err) => {
        console.log(err.data)
      })
    },
  },
};
</script>

<style scoped>
.myRes {
  background-image: url("../assets/myres.jpg");
}
</style>
