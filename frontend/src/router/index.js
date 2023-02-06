import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import FilmsView from "../views/FilmsView.vue";
import RegisterView from "../views/RegisterView.vue";
import LoginView from "../views/LoginView";
import FilmView from "../views/FilmView";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/films",
    name: "films",
    component: FilmsView,
  },
  {
    path: "/register",
    name: "register",
    component: RegisterView,
  },
  {
    path: "/login",
    name: "login",
    component: LoginView,
  },
  {
    path: "/movie",
    name: "movie",
    component: FilmView,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
