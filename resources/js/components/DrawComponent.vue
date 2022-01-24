<template>

    <div class="w-100" style="background: #ebf7ff; height: 100vh">
        <div class="header-logo text-center">
            <img src="public/image/Pinuno_Logo.png">
        </div>

        <div class="header-sub"></div>


        <div class="main-container text-center">

            <img src="public/image/Sun_BG.png" class="sun">

            <h3>Pinuno Raffle 2022</h3>
            <h2>{{ set.set_name }}</h2>


            <div class="raffleBox">
                <div class="raffleBox-body">
                    <div class="display"></div>
                    <div id="name"></div>
                    <div id="address"></div>
                </div>
                <button class="settings" v-on:click="settings"><img src="public/image/Settings_Png24.png"></button>
                <button class="draw" v-on:click="interval">Pick a Winner</button>
                <button class="refresh" v-on:click="reload"><img src="public/image/Redo_Png24.png"></button>
                <button class="winners" v-on:click="listWinnersModal"><img src="public/image/trophy.png"></button>
                <img class="confetti" src="public/image/6k2.gif">
            </div>




        </div>

        <img src="public/image/Flag_BG.png" class="foot-banner">

        <div class="modal" tabindex="-1" role="dialog" id="list_winners">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">List of Winners</h5>
<!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                            <span aria-hidden="true">&times;</span>-->
<!--                        </button>-->
                    </div>
                    <div class="modal-body">

                        <table class="winners-table">

                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Address</th>
                            </tr>

                            <template v-for="winner in winnerList">
                                <tr>
                                    <td style="font-weight: bold; text-align: center">{{ winner.id }}</td>
                                    <td>{{ winner.name }}</td>
                                    <td>{{ winner.address }}</td>
                                </tr>
                            </template>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="closeModal"><i class="fas fa-times mr-2"></i>Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['members', 'first', 'last', 'set'],


    data() {
        return {
            stopIntervalIn : 50,
            run : 0,
            winnerList: [],
        }
    },

    methods: {


        getWinner() {
            let lastDigit = this.last;
            let firstDigit = this.first;
            let winner = '';

            do
            {
                winner = Math.floor(Math.random() * (lastDigit - firstDigit) - firstDigit);
            }
            while(this.alreadyWon(winner))


            return winner;


            // return winner.toString().padStart(6, "0");
        },


        alreadyWon(winner) {
            let retVal = false;

            this.members.forEach(function(item){

                if(item.id === winner && item.iswinner === 'Y')
                {
                    retVal = true;
                }
            })

            return retVal;
        },


        interval() {

            $(".draw").attr("disabled", "true");

            this.run += 1;
            const winner = this.getWinner().toString();
            const length = winner.length;
            let runProc = this.run;
            let stop = this.stopIntervalIn;

            let run = setInterval(function() {
                if (runProc > length)
                {
                    console.log('stop');
                    clearInterval(run);

                    /* check if the winner already win */

                    setTimeout(function() {
                        this.displayWinner(parseInt(winner));
                    }.bind(this), 1000);
                }
                else
                {
                    let valueToAdd = winner.substr(runProc - 1, 1);
                    $('.display').append("<span>" + valueToAdd + "</span>").css({
                        'font-family'       : '"Playfair Display", serif',
                        'color'             : '#ed1c2d',
                        'font-size'         : '100px'
                    });
                    runProc++;
                }
            }.bind(this), 1000)
        },

        displayWinner(winner) {

            /* check if the winner already win */
            this.members.forEach(function(item) {

                if(item.id === winner)
                {
                    let setUse =  this.set.id;

                    axios.post('markAsWinner', {
                        id      :   winner,
                        set_id  :   setUse,
                    });

                    $("#name").text(item.name);
                    $("#address").text(item.address);
                    $(".draw").text("CONGRATULATIONS!");
                    $(".confetti").css("display", "block");
                }
            }.bind(this))
        },

        reload() {
            location.reload();
        },

        listWinnersModal() {
            $('#list_winners').modal('show');

            axios.get('winners/' + this.set.id).then(
            response => {
                this.winnerList = response.data.winners;
            });
        },

        closeModal() {
            $('#list_winners').modal('hide');
        },

        settings() {
            location.href = 'settings';
        }


    },

    mounted() {

        if(this.set.length > 1)
        {
            $(".confetti").css("display", "block");
            $(".draw").attr("disabled", true).text("CONTRATULATIONS WINNERS!");
        }

        console.log(this.set.set_name);
    }
}
</script>

<style scoped>

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Dongle&family=Inter&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    .header-logo {
        background: #fff;
        padding: 30px 0;
    }

    .header-sub {
        background: #333333;
        height: 20px;
    }

    .main-container {
        position: relative;
    }

    .main-container .sun {
        margin: 0 auto;
        width: 500px;
    }

    .main-container h3 {
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translate(-50%, 0);
        font-size: 60px;
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: #0138ac;
    }


    .main-container h2 {
        position: absolute;
        top: 120px;
        left: 50%;
        transform: translate(-50%, 0);
        font-size: 40px;
        font-weight: 800;
        /*-webkit-text-stroke-width: 0.1px;*/
        /*-webkit-text-stroke-color: #34495e;*/
        color: #333333;
    }

    .main-container .raffleBox {
        position: absolute;
        top: 180px;
        left: 50%;
        transform: translate(-50%, 0);
        width: 600px;
        height: 350px;
        border: 1px solid #000;
        background: #fff;
        z-index: 5;
        padding: 0 10px;
    }

    .raffleBox .display .number {
        font-size: 100px;
        color: #fff;
    }

    #name {
        font-size: 30px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
    }

    #address {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
    }

    .draw {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        border: 0;
        padding: 10px;
        font-size: 30px;
        background: #0138ac;
        color: #fff;
        z-index: 2;
    }

    .foot-banner {
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 1;
    }

    .refresh {
        position: absolute;
        bottom: 75px;
        right: 10px;
        z-index: 2;
        background: none;
        border: none;
    }

    .refresh img {
        width: 25px;
    }

    .settings {
        position: absolute;
        bottom: 75px;
        left: 5px;
        z-index: 2;
        background: none;
        border: none;
    }

    .settings img {
        width: 25px;
    }

    .confetti {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .winners {
        position: absolute;
        bottom: 73px;
        right: 45px;
        z-index: 2;
        background: none;
        border: none;
    }

    .modal .modal-dialog .modal-content .modal-body {
        max-height: 500px;
        overflow: auto;
    }

    .winners img {
        width: 30px;
    }

    .winners-table {
        width: 100%;
    }

    .winners-table tr th {
        padding: 5px 10px;
        border-bottom: 1px solid #b2bec3;
        font-weight: normal;
    }

    .winners-table tr td {
        padding: 5px 10px;
        font-size: 13px;
        text-transform: uppercase;
    }




</style>
