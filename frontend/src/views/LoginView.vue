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
        name="user_ref"
        placeholder="Enter your ref"
        v-model="user_ref"
      />
      <input
        type="button"
        class="text-gray-200 bg-gradient-to-r from-orange-600 font-bold to-gray-900 hover:from-red-500 hover:to-gray-400 w-32 py-4 rounded mx-auto ring-1 ring-gray-300"
        @click="login()"
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
  data() {
    return {
      user_ref: "",
      loggedUserData: "",
    };
  },
  methods: {
    login() {
      const formdata = new FormData();
      formdata.append("user_ref", this.user_ref);
      if (this.user_ref != "") {
        axios({
          url: "http://localhost/CineHall/Backend/users/login",
          method: "post",
          data: formdata,
        })
          .then((res) => {
            // after sucess
            this.reset();
            window.location = "http://localhost:8080/my-reservations";
            localStorage.setItem("user_ref", res.data.unique_key);
            localStorage.setItem("user_name", res.data.first_name);
          })
          .catch((err) => {
            // on error
            Swal.fire({
              icon: "error",
              title: "Failed",
              text: `${err.data.invalid}`,
            });
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
