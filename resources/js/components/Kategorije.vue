<template>
    <div class="container shadow-lg p-3">
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
                                <button type="submit" class="btn btn-outline-primary w-100">
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
            <div class="text-center fs-3 text-danger mt-5">
                Trenutno nema kategorija.
            </div>
        </div>
    </div>
</template>

<script>


export default{
    data(){
        return{
            category:{
                ime:'',
            }
        }
    },
    methods:{
        dodajKategoriju() {
            const Data = {
                ime: this.category.ime,

            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajKategoriju", Data)
                .then((response) => {
                    this.message = response.data.message;
                    this.success = true;
                    this.category = {
                        ime: "",

                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    }
}

</script>

<style lang="scss" scoped></style>
