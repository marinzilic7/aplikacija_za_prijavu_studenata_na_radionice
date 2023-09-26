<template>
    <div class="container d-flex justify-content-center mt-5">
        <div class="col-lg-5">
            <h3 class="text-center">Prijava</h3>
            <form
                @submit.prevent="loginUser()"
                class="shadow-lg border p-4 mt-4"
            >
                <div class="form-floating mb-3">
                    <input
                        type="email"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                        v-model="form.email"
                    />
                    <label for="floatingInput">Email adresa</label>
                </div>
                <p v-if="errors.email" class="text-danger">
                    {{ errors.email[0] }}
                </p>
                <div class="form-floating mb-3 position-relative">
                    <input
                        :type="passwordIcon ? 'text' : 'password'"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                        v-model="form.password"
                    />
                    <label for="floatingInput">Vasa lozinka</label>
                    <span @click="password()">
                        <svg
                            v-if="passwordIcon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            class="bi bi-eye position-absolute end-0 bottom-0 me-3 mb-3"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
                            />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
                            />
                        </svg>

                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            class="bi bi-eye-slash position-absolute end-0 bottom-0 me-3 mb-3"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"
                            />
                            <path
                                d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                            />
                            <path
                                d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                            />
                        </svg>
                    </span>
                </div>
                <p v-if="errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </p>

                <button type="submit" class="btn btn-primary w-100">
                    Prijava
                </button>

                <p class="text-center mt-3">
                    Nemate račun?
                    <span
                        ><a href="/register" class="underline text-blue-600"
                            >Registriraj se</a
                        ></span
                    >
                </p>
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                    v-if="falseLogin"
                >
                    Pogrešan email ili lozinka.
                    <button
                        @click="closeInvalid()"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";

export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            passwordIcon: false,
            falseLogin: false,
            poruka: "",
            errors: {},
        };
    },
    methods: {
        password() {
            this.passwordIcon = !this.passwordIcon;
        },

        closeInvalid() {
            this.falseLogin = false;
        },
        loginUser() {
            const Data = {
                email: this.form.email,
                password: this.form.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/loginUser", Data)
                .then((response) => {
                    this.logMessage = response.data.poruka;

                    this.successRegg = true;
                    if (this.logMessage == "Uspješna prijava") {
                        this.$store.dispatch(
                            "setLoginMessage",
                            this.logMessage
                        );
                        this.$store.commit(
                            "setLoggedInUser",
                            response.data.user
                        );
                        this.successRegg = true;
                        this.falseLogin = false;
                        this.$router.push("/");
                    } else {
                        this.falseLogin = true;
                        this.successRegg = false;
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
    ...mapActions(["setLoginMessage"]),
};
</script>

<style lang="scss" scoped></style>
