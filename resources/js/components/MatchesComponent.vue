<template>
    <div>
        <div class="md:container md:mx-auto">
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
            <div :key="key" class="overflow-x-auto relative shadow-md sm:rounded-lg">

                
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" colspan="2" class="py-3 px-6"> </th>
                            <th scope="col" colspan="4" class="py-3 px-6"> Match </th>
                            <th scope="col" colspan="5" class="py-3 px-6"> BetHouses</th>
                        </tr>
                        <tr>
                            <th scope="col" class="py-3 px-6"> Country </th>
                            <th scope="col" class="py-3 px-6"> League </th>
                            <th scope="col" class="py-3 px-6"> Home</th>
                            <th scope="col" class="py-3 px-6"> </th>
                            <th scope="col" class="py-3 px-6"> Away</th>
                            <th scope="col" class="py-3 px-6"> Op </th>
                            <th scope="col" class="py-3 px-6"> </th>
                            <th scope="col" class="py-3 px-6"> </th>
                            <th scope="col" class="py-3 px-6"> </th>
                            <th scope="col" class="py-3 px-6"> </th>
                            <th scope="col" class="py-3 px-6"> </th>
                        </tr>
                    </thead>
                    <tbody v-for="(league, index) in matches_by_league_list" :key="index">
                        <tr v-for="(match, j) in league.matches" :key="j" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{ league.country }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{ league.league }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{ match.teams.home.name }}</td>
                            <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">vs</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{ match.teams.away.name }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                <span v-show="match.is_bet_oportunity" class="bg-green-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full dark:bg-blue-200 dark:text-blue-800">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{  }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{  }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{  }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{  }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">{{  }}</td>
                        </tr>
                    </tbody>
                </table>
                

                <!--
                <ul v-for="(league, index) in matches_by_league_list" :key="index">
                    <li>
                        <div>
                            
                            <! -- league section -- >
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
                            < !-- league section /-- >

                            <ul class="list-inside ...">
                                <li v-for="(match, j) in league.matches" :key="j">
                                        
                                        <! -- <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.home.logo"> -- >
                                        <label> {{ match.teams.home.name }}</label> 
                                        <label class="font-bold">vs</label> 
                                        <! -- <img class="rounded img-team-flag" alt="team-flag" v-bind:src="match.teams.away.logo"> -- >
                                        <label>{{ match.teams.away.name }}</label>

                                        <span v-show="match.bet_oportunity" class="bg-green-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full dark:bg-blue-200 dark:text-blue-800">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        </span>
                                </li>
                            </ul>
                        </div> <! -- principal row /-- > 
                    </li> <! -- end li /-- >
                </ul> <! -- end ul v-for(index) /-->
            </div> <!-- <div :key="key"> -->
            
            <br>
            <hr>
        </div>
    </div>
</template>

<script>
    export default {
        created() {

        },

        data() {
            return {
                matches_by_league_list: [],
                date: '',
                key: 1 // key variable to refresh to component
            }
        },

        methods: {
            getMatches: function() {
                let self = this;
                axios.get(`api/matches/${self.date}`).then(function (response) {
                    self.matches_by_league_list = response.data.matches_by_league;
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