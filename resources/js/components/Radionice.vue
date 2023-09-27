<template>
    <div class="container d-flex justify-content-center">
        <div
            v-if="spinner"
            class="spinner-grow text-primary position-absolute top-50"
            role="status"
        >
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-if="!spinner" class="container shadow-lg p-3">
        <div>
            <h3 class="text-center mt-5">Radionice</h3>
        </div>
        <hr class="mt-4" />
        <div class="d-flex justify-content-center mt-4">
            <button
                type="button"
                class="btn btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                data-bs-whatever="@getbootstrap"
            >
                Dodaj radionicu
            </button>
            <div
                class="modal fade"
                id="exampleModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Dodaj radionicu
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="dodajRadionicu()">
                                <div class="form-floating mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="floatingInput"
                                        placeholder="name@example.com"
                                        v-model="radionica.ime"
                                    />
                                    <label for="floatingInput"
                                        >Ime radionice</label
                                    >
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea
                                        class="form-control"
                                        placeholder="Leave a comment here"
                                        id="floatingTextarea2"
                                        style="height: 100px"
                                        v-model="radionica.opis"
                                    ></textarea>
                                    <label for="floatingTextarea2"
                                        >Opis radionice</label
                                    >
                                </div>
                                <select
                                    class="form-select form-select-sm mb-3"
                                    aria-label=".form-select-sm example"
                                    v-model="radionica.category_id"
                                >
                                    <option selected>
                                        Odaberi kategoriju
                                    </option>
                                    <option v-for="category in categories" :value="category.id">{{ category.ime }}</option>

                                </select>

                                <button
                                    type="submit"
                                    class="btn btn-outline-primary w-100"
                                >
                                    Dodaj
                                </button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-outline-secondary w-100"
                                data-bs-dismiss="modal"
                            >
                                Zatvori
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div>
            <h3 class="text-center mt-3">Sve radionice</h3>
            <div v-if="noRadionice" class="text-center fs-3 text-danger mt-5">
                Trenutno nema radionica.
            </div>
            <ul class="list-group" v-else>
                <li
                    v-for="radionica in radionice"
                    class="list-group-item d-flex justify-content-between align-items-center"
                >
                    {{ radionica.ime }}
                    <button
                        @click="deleteCategory(radionica.id)"
                        class="btn btn-sm btn-outline-danger"
                    >
                        Izbrisi
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            radionica: {
                ime: "",
                opis:"",
                category_id:null,
            },
            categories: [],
            radionice:[],
            brojRadionica: null,
            noRadionice: false,
            spinner: true,
        };
    },
    created() {
        this.getCategory();
        this.getRadionicu();
    },
    methods: {
        dodajRadionicu() {
            const Data = {
                ime: this.radionica.ime,
                opis: this.radionica.opis,
                category_id: this.radionica.category_id,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajRadionicu", Data)
                .then((response) => {
                    this.message = response.data.message;
                    $("#exampleModal").modal("hide");
                    this.success = true;
                    this.radionica = {
                        ime: "",
                        opis:"",
                        category_id:"",
                    };
                    this.errors = {};
                    this.getRadionicu();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        getCategory() {
            axios
                .get("/getCategory")
                .then((response) => {
                    this.categories = response.data.category;
                    this.brojKategorija = response.data.brojKategorija;
                    if (this.brojKategorija == 0) {
                        this.noCategory = true;
                    } else {
                        this.noCategory = false;
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })

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
        deleteCategory(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/deleteCategory/${id}`)
                .then((response) => {
                    this.message = response.data.message;
                    this.getCategory();
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

<style lang="scss" scoped></style>
