<style lang="sass" scoped>
$accent: #000;

#feedback {
    position: absolute;
    bottom: 2%;
    width: 100%;
    cursor: pointer;
    text-align: center;

    // .options {
    //     margin: auto;
    //     margin-bottom: 1%;
    // }

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

    .box {
        font-size: 1.4em;
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
}
</style>

<template>
<div>
    <div id="feedback">
        <!-- <div class="options" v-if="showFeedbackOpt">
            <span class="option" v-for="opt in options" @click="submit(opt.code)">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                </span>
            </span>
        </div> -->

        <div class="button" @click="toggleOpts">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </div>
    </div>

    <div id="form">
        <div v-if="showFeedbackOpt" class="box">
            <ul>
                <li v-for="category in categories">
                    {{ category.label }}
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
                // options: [
                //     { code: 'trash', icon: 'trash' },
                //     { code: 'trash', icon: 'trash' },
                //     { code: 'trash', icon: 'trash' },
                //     { code: 'trash', icon: 'trash' },
                //     { code: 'trash', icon: 'trash' },
                // ],
                categories: [
                    {label: 'lorem1'},
                    {label: 'lorem2'},
                    {label: 'lorem3'},
                    {label: 'lorem4'},
                    {label: 'lorem5'},
                    {label: 'lorem6'},
                    {label: 'lorem7'},
                    {label: 'lorem8'},
                ],
                showFeedbackOpt: true,
                isLoading: false,
                isDone: false
            };
        },

        ready() {
            // this.$http.get(`api/feedback-category`).then((res) => {
            //     this.$set('categories', res.json());
            // });
        },

        methods: {
            toggleOpts() {
                this.showFeedbackOpt = !this.showFeedbackOpt;
            },

            submit(code) {
                // @TODO - Persist data-point
                this.isLoading = true;

                Locator.getLocation((coordinates) => {
                    console.log('Persist: ', coordinates);

                    // @TODO - on backend callback.
                    setTimeout(() => {
                        this.isLoading = false;
                        this.isDone = true;

                        setTimeout(() => {
                            this.isDone = false;
                            this.toggleOpts();
                        }, 4000);

                    }, 2000);
                }, (errorMsg) => {
                    alert(errorMsg);
                });
            }
        }
    }
</script>
