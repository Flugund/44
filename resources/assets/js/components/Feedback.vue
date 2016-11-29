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
    top: 5%;
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
        overflow: auto;
        font-size: 1.2em;
        font-weight: 200;
        margin: auto;
        background-color: #fff;
        width: 50%;
        border-radius: 3px;
        padding: 2em;
    }
}

.align-footer {
    vertical-align: top;
    display: inline-block;
}
</style>

<template>
<div>
    <div id="feedback">
        <div class="button" @click="toggleOpts">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </div>
    </div>

    <div id="form" v-if="showFeedbackOpt">
        <div class="box">
            <div class="form">
                <div class="col-sm-12">
                    <h2>Give your feedback</h2>

                    <div class="form-group">
                        <select class="form-control" required v-model="selectedFeedbackFilter">
                            <option selected="selected" disabled="disabled">Feedback type</option>
                            <option :value="1">Positive</option>
                            <option :value="0">Negative</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" required v-model="newFeedback.feedback_category_id">
                            <option selected="selected" disabled="disabled">
                                Reporting reason
                            </option>
                            <option v-for="cat in feedbackCategories" :value="cat.cid">
                                {{ cat.cat_text }}
                            </option>
                        </select>
                    </div>

               <!--      <div class="form-group align-footer">
                        <label class="btn btn-default btn-file">
                            Upload photo <input type="file" style="display: none;">
                        </label>
                    </div> -->

                    <div class="form-group align-footer">
                        <label class="btn btn-default btn-file">
                            Upload photo <input type="file" @change="upload" style="display: none;" id="file_upload_button">
                        </label>
                        <span id = "upload_progress">
                    </div>
                    <input
                        id="id_storage_url"
                        name="storage_url"
                        style="display: None;"
                        type="text"
                        value=""
                        required
                    >

                    <button
                        class="btn btn-primary pull-right align-footer"
                        @click="submit"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="notifier" v-if="isLoading || isDone">
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
    import Uploader from './Uploader';

    export default {
        data() {
            return {
                categories: [],
                showFeedbackOpt: false,
                isLoading: false,
                isDone: false,

                selectedFeedbackFilter: 0,

                newFeedback: {
                    feedback_category_id: '',
                    url: ''
                }
            };
        },

        ready() {
            this.$http.get(`api/feedback-category`).then((res) => {
                this.$set('categories', res.json());
            });
        },

        computed : {
            feedbackCategories() {
                return _.filter(this.categories, (category) => {
                    return category.positive == this.selectedFeedbackFilter;
                });
            }
        },

        methods: {
            toggleOpts() {
                this.showFeedbackOpt = !this.showFeedbackOpt;
            },

            submit() {
                this.isLoading = true;
                this.toggleOpts();

                Locator.getLocation((coordinates) => {
                    this.$http.post(`api/feedback`, {
                        lon: coordinates.lng,
                        lat: coordinates.lat,
                        // tstamp: '',
                        picture_url: document.getElementById('id_storage_url').value,
                        // userid: '',
                        feedback_category_id: this.newFeedback.categoryCid
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
            },

            upload() {
                var kmskeyid = '';
                var obj = document.getElementById('file_upload_button');
                var folder = Math.random().toString();

                Uploader.upload(obj, folder);
            }
        }
    }
</script>
