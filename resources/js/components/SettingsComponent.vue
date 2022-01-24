<template>

    <div class="w-100 p-2" style="background: #ebf7ff; height: 100vh">
        <div class="row">
            <div class="col-5">
                <div class="card" style="height: 300px">
                    <div class="card-header">
                        Sets

                        <button style="float: right" v-on:click="addSet">Add</button>
                    </div>

                    <div class="card-body">
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center">Winners</th>
                                    <th class="text-center">Winners Count</th>
                                    <th class="text-center">Order</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="set in setsData">
                                    <tr>
                                        <td>{{ set.set_name }}</td>
                                        <td class="text-center">{{ set.winners }}</td>
                                        <td class="text-center">{{ set.winnerCount }}</td>
                                        <td class="text-center">{{ set.order }}</td>
                                        <td class="text-center"><button v-on:click="deleteSet(set.id)">x</button></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="addModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="addset === true">Add New Set</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="from-group" v-if="addset === true">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="setTempData.set_name">

                            <label for="winner">Winner</label>
                            <input type="number" class="form-control" id="winner" v-model="setTempData.winner">

                            <label for="order">Order</label>
                            <input type="number" class="form-control" id="order" v-model="setTempData.order">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" v-if="addset === true" v-on:click="saveSet">Save Set</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {

    props: ['sets'],

    data() {

        return {

            setsData: this.sets,
            addset: false,
            setTempData: [],

        }

    },

    methods: {

        addSet() {
            $("#addModal").modal('show');
            this.addset = true;
        },

        saveSet() {


            if(!this.setTempData.set_name || !this.setTempData.winner || !this.setTempData.order) {
                this.$fire({
                    title: "Required Fields",
                    text: "Set name. Winner and Order is Required",
                    type: "error",
                });

                return;
            }



            axios.post('addset', {
                set_name    : this.setTempData.set_name,
                winner      : this.setTempData.winner,
                order       : this.setTempData.order,
            }).then(response => {
                this.$fire({
                    title: "Saved Data",
                    text: response.data.msg,
                    type: "success",
                }).then(r => {
                    location.reload();
                });
            }).catch(error => {
                this.$fire({
                    title: "Unable to save",
                    text: error.response.data.msg,
                    type: "error",
                });
            })
        },

        deleteSet(id) {
            console.log(id);
        },

    },

    mounted() {

    }


}
</script>

<style scoped>



</style>
