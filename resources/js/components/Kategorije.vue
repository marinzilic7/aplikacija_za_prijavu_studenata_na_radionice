<template>
    <div class="container d-flex justify-content-center">
        <div v-if="spinner" class="spinner-grow text-primary position-absolute top-50" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-if="!spinner" class="container shadow-lg p-3">
        <div>
            <h3 class="text-center mt-5">Kategorije</h3>
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
                Dodaj kategoriju
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
                                Dodaj kategoriju
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="dodajKategoriju()">
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Naziv kategorije</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="category.ime"
                                    />
                                </div>
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
            <h3 class="text-center mt-3">Sve kategorije</h3>
            <div v-if="noCategory" class="text-center fs-3 text-danger mt-5">
                Trenutno nema kategorija.
            </div>
            <ul class="list-group" v-else>
                <li
                    v-for="category in categories"
                    class="list-group-item d-flex justify-content-between align-items-center"
                >
                    {{ category.ime }}
                    <button
                        @click="deleteCategory(category.id)"
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
            category: {
                ime: "",
            },
            categories: [],
            brojKategorija: null,
            noCategory: false,
            spinner:true,
        };
    },
    created() {
        this.getCategory();
    },
    methods: {
        dodajKategoriju() {
            const Data = {
                ime: this.category.ime,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajKategoriju", Data)
                .then((response) => {
                    this.message = response.data.message;
                    $("#exampleModal").modal("hide");
                    this.success = true;
                    this.category = {
                        ime: "",
                    };
                    this.errors = {};
                    this.getCategory();
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
                }).finally(() => {
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
