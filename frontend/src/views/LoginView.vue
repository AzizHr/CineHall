<template>
  <div class="login bg-cover bg-center bg-no-repeat h-screen px-5">
    <form class="grid gap-6 md:gap-12 content-center md:w-1/2 h-full mx-auto">
      <h1
        class="text-center text-lg md:text-3xl font-bold md:text-left text-gray-100"
      >
        Welcome again , Login!
      </h1>
      <input
        class="border py-4 pl-3 rounded"
        type="text"
        name="ref"
        placeholder="Enter your ref"
        v-model="client_ref"
      />
      <input
        type="button"
        class="text-gray-200 bg-gradient-to-r from-orange-600 font-bold to-gray-900 hover:from-red-500 hover:to-gray-400 w-32 py-4 rounded mx-auto ring-1 ring-gray-300"
        @click="auth()"
        value="Login"
      />
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "LoginView",
  mounted() {
    if (localStorage.getItem("client_ref")) {
      window.location = "http://localhost:8080/";
    }
  },
  data() {
    return {
      client_ref: "",
      loggedUserData: "",
    };
  },
  methods: {
    auth() {
      const formdata = new FormData();
      formdata.append("ref", this.client_ref);
      if (this.client_ref != "") {
        axios({
          url: "http://localhost/CineHall/api/clients/auth",
          method: "post",
          data: formdata,
        }).then((res) => {
          if (res.data == 0) {
            this.reset();
            Swal.fire({
              icon: "error",
              title: "Invalid",
              text: "Your ref is invalid",
            });
          } else {
            window.location = "http://localhost:8080/my-reservations";
            localStorage.setItem("client_ref", res.data.ref);
            localStorage.setItem("client_name", res.data.first_name);
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: "Please Fill in inputs",
        });
      }
    },
    reset() {
      this.user_ref = "";
    },
  },
};
</script>

<style scoped>
.login {
  background-image: url("../assets/login_main_image.jpg");
}
</style>
