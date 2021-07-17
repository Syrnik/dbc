<template>
    <wa-field-simple :value_class="[{submit:true}, submitStatus]">
        <button class="green button" type="button" @click="save" :disabled="buttonDisabled">Сохранить</button>
        <span v-show="submit_status.length"><i :class="submitIconClass" v-if="submit_status.length"></i> {{submit_status_msg}}</span>
    </wa-field-simple>
</template>

<script>
    import WaFieldSimple from './wa-field-simple.vue';

    export default {
        name: "wa-submit-field",
        props: {
            settings: {type: Object, required: true},
            url: {type: String, required: true},
            allowed: {type: Boolean, default: true},
            iconClass: {}
        },
        data() {
            return {
                submit_status_msg: '',
                submit_status: '',
                running: false
            }
        },
        components: {WaFieldSimple},
        computed: {
            submitStatus() {
                if (this.submit_status === 'success') return ['success', 'successmsg'];
                return [];
            },
            submitIconClass() {
                switch (this.submit_status) {
                    case 'loading':
                        return this.iconClass.loading || ['icon16', 'loading'];
                    case 'success':
                        return this.iconClass.success || ['fas', 'fa-check']
                }
            },
            buttonDisabled() {
                return this.running || !this.allowed;
            }
        },
        methods: {
            save() {
                this.submit_status = 'loading';
                this.running = true;
                this.$emit('submitting', true);
                $.shop.jsonPost(
                    this.url,
                    {settings: JSON.stringify(this.settings)},
                    r => {
                        if (r.data && r.data.message) {
                            this.submit_status_msg = r.data.message;
                            this.submit_status = 'success';
                            setTimeout(() => {
                                this.submit_status = '';
                                this.submit_status_msg = '';
                            }, 5000);
                        }
                    }
                ).always(()=>{
                    this.running = false;
                    this.$emit('submitting', false);
                });
            }
        }
    }
</script>
