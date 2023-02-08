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
        name="fname"
        placeholder="Enter your last name"
        v-model="fname"
      />
      <input
        class="border py-4 pl-3 rounded"
        type="text"
        name="lname"
        placeholder="Enter your last name"
        v-model="lname"
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
  data() {
    return {
      fname: "",
      lname: "",
    };
  },
  methods: {
    register() {
      const formdata = new FormData();
      formdata.append("fname", this.fname);
      formdata.append("lname", this.lname);
      if (this.fname != "" && this.lname != "") {
        axios({
          url: "http://localhost/CineHall/Backend/users/register",
          method: "post",
          data: formdata,
        })
          .then((res) => {
            // after sucess
            this.reset();
            Swal.fire({
              icon: "success",
              title: "Done!",
              text: `${res.data.Success}`,
              footer: `<a>${res.data.Ref}</a>`,
            });
          })
          .catch((err) => {
            // on error
            alert(err.Error);
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
