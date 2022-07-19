<template>
    <div>
        <div class="container mx-auto">
            <div class="flex justify-center">
                <h2 class="font-bold text-gray-700">Lista de Partidos</h2>
            </div>

            <br>
            <div>
                <label for="date" class="inline-block w-20 mr-6 text-right font-bold text-gray-600">Fecha: </label>
                <input v-model="date" type="text" placeholder="YYYY-MM-DD" class="flex-1 appearance-none text-gray-600 placeholder-gray-400 shadow focus:outline-none focus:ring focus:ring-green-300 px-8 py-1 border-gray-300 rounded-lg">
                <button v-on:click="getMatches" class="hover:text-green-600 border border-green-800 hover:border-green-600 rounded py-1 px-8 transition duration-500 font-bold">Buscar</button>
            </div>

            <br>
            <div :key="key">
                <ul v-for="(league, index) in matches_by_league_list" :key="index">
                    <li>
                        <div>
                            
                            <!-- league section -- >
                            <div>
                                <div>
                                    <div>
                                        <img v-bind:src="league.country_flag" alt="country" class="rounded-circle img-country-flag img-thumbnail">
                                        <p>{{ league.country }}</p>
                                    </div>
                                </div>
                                <div>
                                        <label>Season: {{ league.season }}</label>
                                        <label>Round:  {{ league.round }}</label>
                                </div>
                                <div>
                                    <div>
                                        <img v-bind:src="league.league_logo" alt="league" class="rounded-circle img-league-flag img-thumbnail">
                                        <p>{{ league.league }}</p>
                                    </div>
                                </div>
                            </div>
                            < !-- league section /-->

                            <div class="list-inside">
                            <div v-for="(match, j) in league.matches" :key="j">
                                <li> <!-- secondary row -->
                                    <div>
                                        <div>
                                            <div>
                                                <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.home.logo">
                                            </div>
                                            <div>
                                                <label> {{ match.teams.home.name }}</label>
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <div>
                                                <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.away.logo">
                                            </div>
                                            <div>
                                                <label>{{ match.teams.away.name }}</label>
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- button v-on:click="saveMatch" class="btn btn-md btn-primary">Guardar</button> -->
                                    </div>
                                    <div>
                                        <span v-show="match.bet_oportunity">+</span>
                                    </div>
                                </li> <!-- secondary row /-->
                            </div> <!-- end v-for(j) /-->
                            </div>
                        </div> <!-- principal row /--> 
                    </li> <!-- end li /-->
                </ul> <!-- end ul v-for(index) /-->
            </div> <!-- <div :key="key"> -->
            
            <br>
            <hr>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            //this.getMatches(this.formatDate(new Date(), 'yyyy-mm-dd'));

        },

        data() {
            return {
                matches_by_league_list: [],
                date: '',
                key: 1
            }
        },

        methods: {
            getMatches: function() {
                let self = this;
                axios.get(`api/matches/${self.date}`).then(function (response) {
                    self.matches_by_league_list = response.data.matches_by_league;
                    //console.log(response.data);
                }).catch(function (error) {
                    console.error(error);
                }).finally(() => this.refresh());
            },

            saveMatch: function() {

            },

            formatDate(date, format) {
                const map = {
                    dd: (date.getDate() < 10 ) ? '0' + date.getDate() : date.getDate(),
                    mm: (date.getMonth() < 9 ) ? '0' + (date.getMonth() + 1) : date.getMonth() + 1,
                    yyyy: date.getFullYear()
                }
                return format.replace(/yyyy|mm|dd/gi, matched => map[matched])
            },

            refresh() {
                this.key++;
            }
        }
    }
</script>


<style scoped>

.img-country-flag {
    width: 30%;
    height: 10%;
    object-fit: cover;
}

.img-league-flag {
    width: 30%;
    height: 10%;
    object-fit: cover;
}

.img-team-flag {
    width: 20%;
    height: 5%;
    object-fit: cover;
}

</style>