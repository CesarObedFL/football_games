<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-9">
                        <h2>Lista de Partidos</h2>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-6">
                        <input v-model="date" type="text">
                        <button v-on:click="getMatches" class="btn btn-md btn-success">Buscar</button>
                    </div>
                </div>

                <!-- 
                <div class="row">
                    {{ matchesByLeagueList }}
                </div>
                -->
                <br>
                <div>
                    <ul v-for="(league, index) in matchesByLeagueList" :key="index">
                        <li>
                            <div class="row jumbotron jumbotron-fluid">
                                
                                <!-- league section -->
                                <div class="row col-sm-12 container bg-info">
                                    <div class="col-md-3">
                                        <div class="col text-center">
                                            <img v-bind:src="league.country_flag" alt="country" class="rounded-circle img-country-flag img-thumbnail">
                                            <p class="text-justify">{{ league.country }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <label>{{ 'Season: ' }}</label>
                                            <label>{{ 'Round:' }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col text-center">
                                            <img v-bind:src="league.league_logo" alt="league" class="rounded-circle img-league-flag img-thumbnail">
                                            <p class="text-justify">{{ league.league }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- league section /-->

                                <div class="col-md-12" v-for="(match, j) in league.matches" :key="j">
                                    <div class="row"> <!-- secondary row -->
                                        <div class="col-sm-5">
                                            <div class="container">
                                                <div class="col text-center">
                                                    <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.home.logo">
                                                </div>
                                                <div>
                                                    <label> {{ match.teams.home.name }}</label>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="container">
                                                <div class="text-center">
                                                    <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.away.logo">
                                                </div>
                                                <div>
                                                    <label>{{ match.teams.away.name }}</label>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button v-on:click="saveMatch" class="btn btn-md btn-primary">Guardar</button>
                                        </div>
                                    </div> <!-- secondary row /-->
                                </div> <!-- end v-for(j) /-->
                            </div> <!-- principal row /--> 
                        </li> <!-- end li /-->
                    </ul> <!-- end ul v-for(index) /-->
                </div>
            </div>
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
                matchesByLeagueList: [],
                date: ''
            }
        },

        methods: {
            getMatches: function() {
                let self = this;
                axios.get('api/matches/'+self.date).then(function (response) {
                    self.matchesByLeagueList = response.data.matchesByLeague
                    console.log(response);
                }).catch(function (error) {
                    console.log(error);
                });
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