<style lang="sass" scoped>
$accent: #000;

#feedback {
    position: absolute;
    bottom: 2%;
    width: 100%;
    cursor: pointer;
    text-align: center;

    .options {
        margin: auto;
        margin-bottom: 1%;
    }

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
</style>

<template>
<div>
    <div id="feedback">
        <div class="options" v-if="showFeedbackOpt">
            <span class="option" v-for="opt in options" @click="submit(opt.code)">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                </span>
            </span>
        </div>

        <div class="button" @click="toggleOpts">
            <i class="fa fa-plus" aria-hidden="true"></i>
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
                options: [
                    { code: 'trash', icon: 'trash' },
                    { code: 'trash', icon: 'trash' },
                    { code: 'trash', icon: 'trash' },
                    { code: 'trash', icon: 'trash' },
                    { code: 'trash', icon: 'trash' },
                ],
                showFeedbackOpt: false,
                isLoading: false,
                isDone: false
            };
        },

        ready() {
            // ..
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
            },

            // getLocation(successCb, FailCb) {
            //     // Try HTML5 geolocation.
            //     if (navigator.geolocation) {
            //         navigator.geolocation.getCurrentPosition((position) => {
            //             successCb({
            //                 lat: position.coords.latitude,
            //                 lng: position.coords.longitude
            //             });
            //         }, () => {
            //             failCb('Error: The Geolocation service failed.');
            //         });
            //     } else {
            //         failCb('Error: Your browser doesn\'t support geolocation.');
            //     }
            // }
        }
    }
</script>
