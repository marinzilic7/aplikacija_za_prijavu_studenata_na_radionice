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
                                        v-model="data.ime"
                                        required
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
                                        v-model="data.opis"
                                        required
                                    ></textarea>
                                    <label for="floatingTextarea2"
                                        >Opis radionice</label
                                    >
                                </div>
                                <select
                                    class="form-select form-select-sm mb-3"
                                    aria-label=".form-select-sm example"
                                    v-model="data.category_id"
                                    required
                                >
                                    <option selected>Odaberi kategoriju</option>
                                    <option
                                        v-for="category in categories"
                                        :value="category.id"
                                    >
                                        {{ category.ime }}
                                    </option>
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
            <div class="mt-3" v-else>
                <table class="table table-bordered shadow-lg">
                    <thead>
                        <tr>
                            <th scope="col">Broj radionice</th>
                            <th scope="col">Ime radionice</th>
                            <th scope="col">Opis radionice</th>
                            <th scope="col">Dodao/la</th>
                            <th scope="col">Kategorija</th>
                            <th scope="col">Izbrisi</th>
                            <th scope="col">Uredi</th>
                            <th scope="col">Pogledaj prijave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="radionica in radionice">
                            <th scope="row">{{ radionica.id }}</th>
                            <td>{{ radionica.ime }}</td>
                            <td>{{ radionica.opis }}</td>
                            <td>{{ radionica.user.firstName }}</td>
                            <td>{{ radionica.category.ime }}</td>
                            <td>
                                <button
                                    @click="deleteRadionicu(radionica.id)"
                                    class="btn btn-sm btn-outline-danger"
                                >
                                    Izbrisi
                                </button>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-dark"
                                    data-bs-toggle="modal"
                                    :data-bs-target="
                                        '#exampleModal' + radionica.id
                                    "
                                    data-bs-whatever="@getbootstrap"
                                    @click="updateRadionicu(radionica)"
                                >
                                    Uredi
                                </button>

                                <div
                                    class="modal fade"
                                    :id="'exampleModal' + radionica.id"
                                    tabindex="-1"
                                    :aria-labelledby="
                                        'exampleModalLabel' + radionica.id
                                    "
                                    aria-hidden="true"
                                >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5
                                                    class="modal-title"
                                                    :id="
                                                        '#exampleModal' +
                                                        radionica.id
                                                    "
                                                >
                                                    Uredi radionicu
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    @submit.prevent="
                                                        urediRadionicu(
                                                            radionica.id
                                                        )
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            for="recipient-name"
                                                            class="col-form-label"
                                                            >Ime
                                                            radionice:</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="recipient-name"
                                                            v-model="data.ime"
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            for="message-text"
                                                            class="col-form-label"
                                                            >Opis
                                                            radionice:</label
                                                        >
                                                        <textarea
                                                            class="form-control"
                                                            id="message-text"
                                                            v-model="data.opis"
                                                        ></textarea>
                                                    </div>
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary w-100"
                                                    >
                                                        Uredi
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button
                                                    type="submit"
                                                    class="btn btn-secondary w-100"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-success"
                                    data-bs-toggle="modal"
                                    :data-bs-target="'#prijave' + radionica.id"
                                    @click="pogledajPrijave(radionica.id)"
                                >
                                    Prijave
                                </button>
                                <div
                                    class="modal fade"
                                    :id="'prijave' + radionica.id"
                                    tabindex="-1"
                                    aria-labelledby="exampleModalLabel"
                                    aria-hidden="true"
                                >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5
                                                    class="modal-title"
                                                    id="exampleModalLabel"
                                                >
                                                    Sve prijave za radionicu:
                                                    {{ radionica.ime }}
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center"
                                            >
                                                <div
                                                    v-if="loader"
                                                    class="spinner-grow text-primary"
                                                    role="status"
                                                >
                                                    <span
                                                        class="visually-hidden"
                                                        >Loading...</span
                                                    >
                                                </div>
                                            </div>
                                            <div v-if="!loader">
                                                <div class="modal-body">
                                                    <h5 v-if="noSudionik" class="text-danger">Trenutno nema prijavljenih korisnika</h5>
                                                    <h5 v-if="!noSudionik">
                                                        Prijavljeni korisnici
                                                        su:
                                                    </h5>
                                                    <br />
                                                    <ul>
                                                        <li
                                                            v-for="prijava in prijave"
                                                        >
                                                            {{
                                                                prijava.user
                                                                    .firstName + ' ' + prijava.user.lastName
                                                            }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                ime: "",
                opis: "",
                category_id: null,
            },
            categories: [],
            radionice: [],
            brojRadionica: null,
            noRadionice: false,
            spinner: true,
            radionicaId: null,
            prijave: [],
            loader:true,
            brojSudionika:null,
            noSudionik:false,
        };
    },
    created() {
        this.getCategory();
        this.getRadionicu();
    },
    methods: {
        dodajRadionicu() {
            const Data = {
                ime: this.data.ime,
                opis: this.data.opis,
                category_id: this.data.category_id,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajRadionicu", Data)
                .then((response) => {
                    this.message = response.data.message;
                    $("#exampleModal").modal("hide");
                    this.success = true;
                    this.data = {
                        ime: "",
                        opis: "",
                        category_id: "",
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

        updateRadionicu(radionica) {
            this.radionicaId = radionica.id;
            this.data.ime = radionica.ime;
            this.data.opis = radionica.opis;
            $("#exampleModal" + radionica.id).modal("show");
        },
        urediRadionicu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/urediRadionicu/${id}`, {
                    ime: this.data.ime,
                    opis: this.data.opis,
                })
                .then((response) => {
                    this.poruka = response.data.poruka;

                    const radionica = response.data.radionica;
                    const index = this.radionice.findIndex(
                        (radionica) => radionica.id === this.radionicaId
                    );
                    if (index !== -1) {
                        this.radionice[index].ime = radionica.ime;
                        this.radionice[index].opis = radionica.opis;
                    }
                });
            $("#exampleModal" + this.radionicaId).modal("hide");
        },

        pogledajPrijave(id) {
            axios
                .get(`/getPrijave/${id}`)
                .then((response) => {
                    this.prijave = response.data.clanovi;
                    this.brojSudionika = response.data.brojSudionika;
                    if (this.brojSudionika == 0){
                        this.noSudionik = true;
                    }else{
                        this.noSudionik = false;
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.loader = false;
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
