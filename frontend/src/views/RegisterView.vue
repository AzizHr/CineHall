<template>
  <div class="register bg-cover bg-center bg-no-repeat h-screen px-5">
    <form class="grid gap-6 md:gap-12 content-center md:w-1/2 h-full mx-auto">
      <h1
        class="text-center text-lg md:text-3xl font-bold md:text-left text-white"
      >
        Register Now
      </h1>
      <input
        class="border py-4 pl-3 rounded"
        type="text"
        name="first_name"
        placeholder="Enter your last name"
        v-model="first_name"
      />
      <input
        class="border py-4 pl-3 rounded"
        type="text"
        name="last_name"
        placeholder="Enter your last name"
        v-model="last_name"
      />
      <input
        type="button"
        class="bg-red-400 py-3 w-28 rounded md:mx-0 mx-auto"
        @click="register()"
        value="Register"
      />
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "RegisterView",
  mounted() {
    if (localStorage.getItem("client_ref")) {
      window.location = "http://localhost:8080/";
    }
  },
  data() {
    return {
      first_name: "",
      last_name: "",
    };
  },
  methods: {
    register() {
      const formdata = new FormData();
      formdata.append("first_name", this.first_name);
      formdata.append("last_name", this.last_name);
      if (this.first_name != "" && this.last_name != "") {
        axios({
          url: "http://localhost/CineHall/api/clients/register",
          method: "post",
          data: formdata,
        }).then((res) => {
          // after sucess
          this.reset();
          Swal.fire({
            icon: "success",
            title: "Registration Success",
            html:
              "You can login by clicking " +
              '<a href="/login" class="text-blue-500 underline">here</a>',
            footer: `<a>${res.data.Ref}</a>`,
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
      (this.fname = ""), (this.lname = "");
    },
  },
};
</script>

<style scoped>
.register {
  background-image: url("../assets/register_main_image.jpg");
  /* object-fit: contain; */
  /* background-size: contain;
  height: 100vh; */
}
</style>
