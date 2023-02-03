<template>
  <div class="register">
    <h1 class="text-center mt-12 text-xl">Register Now</h1>
    <form class="grid gap-6">
      <input
        type="text"
        name="fname"
        placeholder="last name..."
        v-model="fname"
      />
      <input
        type="text"
        name="lname"
        placeholder="last name..."
        v-model="lname"
      />
      <input
        type="button"
        class="bg-red-400"
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
              text: 'Please Fill in inputs',
            });
      }
    },
    reset() {
      (this.fname = ""), (this.lname = "");
    },
  },
};
</script>
