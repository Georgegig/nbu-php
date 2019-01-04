'use strict';
let PortfolioView = {
    template: `
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card class="green lighten-4">
                    <v-card-text class="px-0"><h2><b>Total amount: {{totalAmount}} USD</b></h2></v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap v-for="p in portfolio" :key="p.id">
            <v-flex xs12>
                <v-card class="grey lighten-4">
                    <v-card-text class="px-0"><h2><b>{{p.name}} - Amount: {{p.amount}} Price: {{p.price_usd}} USD</b></h2></v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row justify-center>
            <v-btn dark fab color="blue" center slot="activator" v-on:click="selectCoinDialog=true">
                <v-icon>add</v-icon>
            </v-btn>
            <v-btn dark fab color="blue" center v-on:click="deletePortfolio()">
                <v-icon>delete</v-icon>
            </v-btn>
            <v-btn dark fab color="blue" center v-on:click="refreshPortfolio()">
                <v-icon>refresh</v-icon>
            </v-btn>
            <v-dialog v-model="selectCoinDialog" scrollable max-width="600px">                
                <v-card>
                    <v-card-title>Select Coin</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text style="height: 500px;">
                        <v-text-field label="Filter" single-line v-model="filter"></v-text-field>
                        <div style="cursor:pointer;" v-on:click="addCoin(coin)" v-for="coin in coins" :key="coin.id">
                            <v-divider></v-divider>
                            <h2><b>{{coin.rank}}. {{coin.name}}</b></h2>
                            <v-divider></v-divider>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog v-model="addCoinDialog" scrollable max-width="600px">
                <v-card>
                    <v-card-title><h2><b>{{selectedCoin.name}}</b></h2></v-card-title>
                    <v-divider></v-divider>
                    <v-card-text style="height: 500px;">
                        <v-form v-model="valid" ref="form">
                            <v-text-field label="Amount" v-model="selectedCoin.amount" type="number" :rules="amountRules" required></v-text-field>
                            <v-btn @click="add()" :disabled="!valid" color="primary" white--text><b>Add</b></v-btn>
                            <v-btn @click="selectCoin()">Go back</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-layout>
    </v-container>`,
    data() {
        return {
            totalAmount: 0,
            allCoins: [],
            coins: [],
            selectCoinDialog: false,
            addCoinDialog: false,
            filter: '',
            selectedCoin: {},
            valid: true,
            amountRules: [
                (v) => !!v || 'Amount is required'
            ],
            portfolio: []
        }
    },
    mounted(){
        if(UsersTable.userLoggedIn()){
            this.refreshPortfolio();
    
            this.$http.get('https://api.coinmarketcap.com/v1/ticker/?start=0&limit=1400').then(
                (data) => {
                    this.allCoins = data.body;
                    this.coins = this.allCoins;
                },
                (err) => {
                    console.log(err);
                }
            );
        }
        else {
            this.$router.push('/');
        }
    },
    watch: {
        filter: function(newFilter) {
            this.filterCollection();
        },
        addCoinDialog: function(newValue){
            if(!newValue){
                this.selectedCoin = {};
            }
        }
    },
    methods: {
        filterCollection(){
            this.coins = _.filter(this.allCoins, (el) => {
                return _.includes(el.name.toLowerCase(), this.filter.toLowerCase());
            });
        },
        addCoin(coin) {
            this.selectedCoin = coin;
            delete this.selectedCoin.amount;
            this.selectCoinDialog = false;
            this.addCoinDialog = true;
        },
        selectCoin() {
            this.selectCoinDialog = true;
            this.addCoinDialog = false;
        },
        add() {
            if (this.$refs.form.validate()) {                
                let coinIndex = _.findIndex(this.portfolio, (el) => {
                    return el.id == this.selectedCoin.id;
                });
                if(coinIndex == -1){
                    this.portfolio.push(this.selectedCoin);
                }
                else {
                    this.portfolio[coinIndex].amount = (parseFloat(this.portfolio[coinIndex].amount) +
                        parseFloat(this.selectedCoin.amount)).toFixed(2);
                }
                PortfolioTable.updateUserPortfolio(this.portfolio);
                this.refreshPortfolio();
                this.addCoinDialog = false;
            }
        },
        refreshPortfolio() {  
            this.portfolio = PortfolioTable.getUserPortfolio();
            this.portfolio = this.portfolio ? this.portfolio : [];       
            if(this.portfolio && this.portfolio.length > 0){
                this.totalAmount = 0;
                let promises = [];
                for(var i = 0; i < this.portfolio.length; i++){
                    promises.push(this.$http.get(`https://api.coinmarketcap.com/v1/ticker/${this.portfolio[i].id}/`));
                }
                Promise.all(promises).then(
                    (responseArray) => {
                        for(let i = 0; i < responseArray.length; i++){
                            let response = responseArray[i].body[0];
                            let coinIndex = _.findIndex(this.portfolio, (el) => {
                                return el.id == response.id;
                            });
                            let currentCoin = this.portfolio[coinIndex];
                            let currCoinAmount = currentCoin.amount;
                            this.portfolio[coinIndex] = response;
                            this.portfolio[coinIndex].amount = currCoinAmount;
                            this.totalAmount += parseFloat(currCoinAmount) * parseFloat(response.price_usd);
                        }
                        this.totalAmount = this.totalAmount.toFixed(2);
                        PortfolioTable.updateUserPortfolio(this.portfolio);
                    },
                    (err) => { console.log(err); }
                );
            }
            else{
                this.totalAmount = 0;
            }
        },
        deletePortfolio() {
            PortfolioTable.deleteUserPortfolio();
            this.refreshPortfolio();
        }
    }
};