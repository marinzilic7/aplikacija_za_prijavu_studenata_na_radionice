<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
    <nav class="bg-blue-600 border-gray-200 bg-blue-600">
        <div
            class="max-w-screen-full flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <a href="https://flowbite.com/" class="flex items-center">
                <img
                    src="https://www.sum.ba/logo.png"
                    class="h-8 mr-3"
                    alt="Flowbite Logo"
                />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
                    >Radionica</span
                >
            </a>
            <div class="flex md:order-2">
                <button
                    type="button"
                    data-collapse-toggle="navbar-search"
                    aria-controls="navbar-search"
                    aria-expanded="false"
                    class="md:hidden text-gray-500 text-white hover:bg-gray-100 dark:hover:bg-blue-500 focus:outline-none rounded-lg text-sm p-2.5 mr-1"
                >
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
                <div class="relative hidden md:block">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </div>
                    <input
                        type="text"
                        id="search-navbar"
                        class="block w-full p-2 pl-10 text-sm text-white bg-blue-600 focus:ring-blue-900 focus:border-white-500 dark:bg-blue-600 dark:border-white dark:placeholder-white dark:text-white"
                        placeholder="Search..."
                    />
                </div>
                <button
                    data-collapse-toggle="navbar-search"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-blue-500 focus:outline-none focus:ring-2"
                    aria-controls="navbar-search"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 17 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15"
                        />
                    </svg>
                </button>
                <button
                    v-if="isLoggedIn"
                    id="dropdownDefaultButton"
                    data-dropdown-toggle="dropdown"
                    class="text-white ms-3 text-sm bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    {{ loggedInUser.firstName }}
                    <svg
                        class="w-2.5 h-2.5 ml-2.5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 10 6"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 4 4 4-4"
                        />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div
                    id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                >
                    <ul
                        class="py-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownDefaultButton"
                    >
                        <li>
                            <a
                                @click="logout()"
                                href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                >Odjava</a
                            >
                        </li>
                    </ul>
                </div>
                <ul
                    v-if="!isLoggedIn"
                    class="flex items-center md:justify-end max-sm:hidden max-md:hidden"
                >
                    <li>
                        <RouterLink class="text-white me-3 ms-5" to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li>
                        <RouterLink class="text-white me-3 ms-3" to="/login"
                            >Login</RouterLink
                        >
                    </li>
                </ul>
            </div>
            <div
                class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                id="navbar-search"
            >
                <div class="relative mt-3 md:hidden">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="search-navbar"
                        class="block w-full p-2 pl-10 text-sm text-white focus:ring-blue-500 dark:bg-blue-600 dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search..."
                    />
                </div>
                <ul class="flex flex-col p-4 md:p-0 mt-4">
                    <li class="max-md:text-center text-xl">
                        <RouterLink class="text-white" to="/">Home</RouterLink>
                    </li>
                    <li class="max-md:text-center text-xl mt-3">
                        <RouterLink
                            class="text-white me-3 ms-5 lg:hidden md:hidden"
                            to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li class="max-md:text-center text-xl mt-3">
                        <RouterLink
                            class="text-white me-3 ms-3 md:hidden lg:hidden"
                            to="/login"
                            >Login</RouterLink
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
