<template>
    <div class="wrapper">
        <div class="w-content">
            <div class="wc-box">
                <div class="title">Bản Đồ PMT GROUP</div>
            </div>
        </div>
        <div class="wc-box">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.0186955037702!2d105.75246647588705!3d20.99188768904278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134534f4237b64d%3A0x54175b249f446524!2zUE1UIEdyb3VwIC0gQ8O0bmcgVHkgQ-G7lSBQaOG6p24gUE1UIEdyb3Vw!5e0!3m2!1svi!2s!4v1700413314758!5m2!1svi!2s" height="600" style="border:0; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="bar-clear"><div class="dash"></div></div>
        <div class="w-content page">
            <div class="wc-box">
                <ContactContent />
            </div>
        </div>
    </div>
</template>

<script>
    import ContactContent from '../../commons/content/ContactContent.vue';


    export default {
        name: 'Contact',
        components: {
            ContactContent
        },
        data() {
            return {

            }
        },
        mounted() {

        },
        methods: {
        }
    }
</script>
