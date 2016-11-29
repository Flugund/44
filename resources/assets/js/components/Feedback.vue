<style lang="sass" scoped>
$accent: #000;

#feedback {
    position: absolute;
    bottom: 2%;
    width: 100%;
    cursor: pointer;
    text-align: center;

    .button {
        margin: auto;
        width: 50px;
        height: 50px;
        background-color: #FFF;
        border: 3px solid $accent;
        color: $accent;
        border-radius: 50%;
        font-size: 2em;
        line-height: 1.6em;
    }
}

#notifier {
    position: absolute;
    top: 15%;
    width: 100%;
    text-align: center;

    .notify {
        font-size: 3em;
        font-weight: 200;
        margin: auto;
        background-color: #fff;
        width: 50%;
        text-align: center;
        border-radius: 3px;
        padding: 3em;
    }
}

#form {
    position: absolute;
    top: 5%;
    width: 100%;
    height: 80%;
    overflow-y: scroll;

    .box {
        font-size: 1.2em;
        font-weight: 200;
        margin: auto;
        background-color: #fff;
        width: 50%;
        border-radius: 3px;
        padding: 2em;
    }
}

ul {
    list-style-type: none;

    li {
        border-radius: 3px;
        border: 1px solid #ccc;
        padding: .5em;
        margin-bottom: .3em;
        cursor: pointer;
        background-color: #fff;

        &:hover {
            background-color: #ccc;
        }
    }
}
</style>

<template>
<div>
    <div id="feedback">
        <div class="button" @click="toggleOpts">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </div>
    </div>

    <div id="form">
        <div v-if="showFeedbackOpt" class="box">
            <ul>
                <li v-for="category in categories" @click="submit(category.cid)">
                    {{ category.cat_text }}
                </li>
            </ul>
        </div>
    </div>

    <div id="notifier">
        <div v-if="isLoading" class="notify">
            <div class="gps_ring large inline"></div>
        </div>

        <div v-if="isDone" class="notify">
            <p>Thank you for your contribution!</p>
        </div>
    </div>
</div>
</template>

<script>
    import Locator from './Locator';

    export default {
        data() {
            return {
                categories: [],
                showFeedbackOpt: false,
                isLoading: false,
                isDone: false
            };
        },

        ready() {
            this.$http.get(`api/feedback-category`).then((res) => {
                this.$set('categories', res.json());
            });
        },

        methods: {
            toggleOpts() {
                this.showFeedbackOpt = !this.showFeedbackOpt;
            },

            submit(categoryCid) {
                // @TODO - Persist data-point
                this.isLoading = true;
                this.toggleOpts();

                Locator.getLocation((coordinates) => {
                    console.log('Persist: ', coordinates);

                    this.$http.post(`api/feedback`, {
                        lon: coordinates.lng,
                        lat: coordinates.lat,
                        // tstamp: '',
                        // picture_url: '',
                        // userid: '',
                        feedback_category_id: categoryCid
                    }).then((res) => {
                        this.isLoading = false;
                        this.isDone = true;

                        setTimeout(() => {
                            this.isDone = false;
                        }, 4000);
                    });
                }, (errorMsg) => {
                    alert(errorMsg);
                });
            }
        }
    }
</script>
