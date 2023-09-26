<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">Radionica</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li v-if="isLoggedIn">
                        <a
                            class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            href="#offcanvasExample"
                            role="button"
                            aria-controls="offcanvasExample"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="30"
                                height="30"
                                fill="currentColor"
                                class="bi bi-list text-light"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                                />
                            </svg>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="!isLoggedIn">
                        <RouterLink class="nav-link text-light" to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <RouterLink class="nav-link text-light" to="/login"
                            >Login</RouterLink
                        >
                    </li>

                    <li class="nav-item dropdown" v-if="isLoggedIn">
                        <a
                            class="nav-link dropdown-toggle text-light"
                            href="#"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ loggedInUser.firstName }}
                        </a>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdown"
                        >
                            <li>
                                <a
                                    @click="logout()"
                                    class="dropdown-item"
                                    href="#"
                                    >Logout</a
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" v-if="isLoggedIn">
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <button class="btn btn-outline-light" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div
        class="offcanvas offcanvas-start"
        tabindex="-1"
        id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel"
    >
        <div class="offcanvas-header bg-primary">
            <h5 class="offcanvas-title text-light" id="offcanvasExampleLabel">
                Navigation
            </h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="bg-primary">
            <hr class="text-light">
        </div>
        <div class="offcanvas-body bg-primary">
            <div>
                <ul style="list-style-type: none;">
                    <li>
                        <RouterLink class="nav-link text-light text-center fs-5" to="/"
                            >Home</RouterLink
                        >
                    </li>
                    <li>
                        <RouterLink class="nav-link text-light text-center fs-5" to="/radionice"
                            >Radionice</RouterLink
                        >
                    </li>
                    <li>
                        <RouterLink class="nav-link text-light text-center fs-5" to="/kategorije"
                            >Kategorije</RouterLink
                        >
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <RouterView />
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isLoggedIn: false,
        };
    },

    computed: {
        ...mapState(["loginMessage"]),
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        if (this.loginMessage) {
            setTimeout(() => {
                this.$store.commit("setLoginMessage", "");
            }, 2000);
        }
    },
    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    this.loggedInUser = response.data;

                    this.isLoggedIn = true;
                    console.log(this.isLoggedIn);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.loggedInUser = null;
                    this.$store.dispatch("logout");
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
