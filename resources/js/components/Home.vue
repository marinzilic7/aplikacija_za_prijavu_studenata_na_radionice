<template>
    <div v-if="!isLoggedIn">
        <div class="container d-flex justify-content-center">
            <div>
                <div class="alert alert-info mt-5">Prijavite se kako bi mogli da se prijavite u radionice</div>
            </div>
        </div>
    </div>


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

    },
};
</script>

<style lang="scss" scoped>

</style>
