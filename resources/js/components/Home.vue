<template>
    <div v-if="!isLoggedIn">
        <div class="container d-flex justify-content-center">
            <div>
                <div class="alert alert-info mt-5">
                    Prijavite se kako bi mogli da se prijavite u radionice
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center mt-5">Radionice</h2>
    <div class="d-flex gap-4 flex-wrap ms-5 mt-5">
        <div
            class="card shadow-lg"
            v-for="radionica in radionice"
            style="width: 18rem"
        >
            <div class="card-body">
                <h5 class="card-title">Ime radionice: {{ radionica.ime }}</h5>
                <hr />
                <h6 class="card-subtitle mb-2 text-muted">
                    Dodao/la:
                    {{
                        radionica.user.firstName + " " + radionica.user.lastName
                    }}
                </h6>
                <hr />
                <h6 class="card-subtitle mb-2 text-muted">
                    Kategorija:
                    {{ radionica.category.ime }}
                </h6>
                <hr />
                <p class="card-text">
                    {{ radionica.opis }}
                </p>
                <hr />
                <div>
                    <button
                        type="button"
                        class="btn btn-outline-primary w-100"
                        data-bs-toggle="modal"
                        :data-bs-target="'#staticBackdrop' + radionica.id"
                        :disabled="!isLoggedIn"
                    >
                        Prijavi se
                    </button>
                    <div
                        class="modal fade"
                        :id="'staticBackdrop' + radionica.id"
                        tabindex="-1"
                        data-bs-backdrop="static"
                        data-bs-keyboard="false"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Zelite se prijaviti na radionicu
                                        {{ radionica.ime }}?
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                        @click="
                                            closeNoti();
                                            closeSuccess();
                                        "
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        @submit.prevent="
                                            posaljiPrijavu(radionica)
                                        "
                                    >
                                        <p class="mb-3">
                                            Ime radionice: {{ radionica.ime }}
                                        </p>
                                        <p class="mb-3">
                                            Opis radionice: {{ radionica.opis }}
                                        </p>
                                        <hr />
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary w-100"
                                        >
                                            Potvrdi prijavu
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary w-100"
                                        data-bs-dismiss="modal"
                                        @click="
                                            closeNoti();
                                            closeSuccess();
                                        "
                                    >
                                        Close
                                    </button>
                                    <div
                                        class="alert alert-warning w-100 alert-dismissible fade show"
                                        role="alert"
                                        v-if="prijavaExist"
                                    >
                                        Vec ste prijavljeni na ovu radionicu.
                                        <button
                                            @click="closeNoti()"
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="alert"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div
                                        class="alert alert-info w-100 alert-dismissible fade show"
                                        role="alert"
                                        v-if="prijavljenKorisnik"
                                    >
                                        Uspjesna prijava.
                                        <button
                                            @click="closeSuccess()"
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="alert"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <p class="text-muted">
                    Objavljeno: {{ formattedDate(radionica.created_at) }}
                </p>
                <hr />
                <button
                    @click="deleteRadionicu(radionica.id)"
                    class="btn w-100 btn-outline-danger"
                    :disabled="!isLoggedIn"
                >
                    Izbrisi radionicu
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { format, differenceInDays } from "date-fns";
import { hr } from "date-fns/locale";
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isLoggedIn: false,
            radionice: [],
            prijava: {
                workshop_id: "",
            },
            prijavaExist: false,
            prijavljenKorisnik: false,
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
        this.getRadionicu();
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
        getRadionicu() {
            axios
                .get("/getRadionicu")
                .then((response) => {
                    this.radionice = response.data.radionica;
                    this.brojRadionica = response.data.brojRadionica;
                    if (this.brojRadionica == 0) {
                        this.noRadionice = true;
                    } else {
                        this.noRadionice = false;
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
        formattedDate(created_at) {
            const currentDate = new Date();
            const dateToFormat = new Date(created_at);

            const daysDifference = differenceInDays(currentDate, dateToFormat);

            if (daysDifference === 0) {
                return "Danas";
            } else if (daysDifference === 1) {
                return "Jučer";
            } else {
                return `Prije ${daysDifference} dana`;
            }
        },

        posaljiPrijavu(radionica) {
            const Data = {
                workshop_id: radionica.id,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajPrijavu", Data)
                .then((response) => {
                    this.message = response.data.message;
                    $("#exampleModal").modal("hide");
                    this.prijavljenKorisnik = true;
                    this.prijava = {
                        workshop_id: "",
                    };
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else if (
                        error.response &&
                        error.response.status === 400
                    ) {
                        this.prijavaExist = true;
                    }
                });
        },
        closeNoti() {
            this.prijavaExist = false;
        },
        closeSuccess() {
            this.prijavljenKorisnik = false;
        },
        deleteRadionicu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/deleteRadionicu/${id}`)
                .then((response) => {
                    this.message = response.data.message;
                    this.getRadionicu();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    },
};
</script>

<style scoped></style>
