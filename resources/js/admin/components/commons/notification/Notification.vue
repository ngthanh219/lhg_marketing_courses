<template>
    <div class="notification-dialog">
        <div 
            class="alert alert-dismissible"
            v-bind:class="[
                $store.state.notification.success == 1 ? 'alert-success' : 'alert-danger'
            ]"
        >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>
                <i 
                    class="icon fas"
                    v-bind:class="[
                        $store.state.notification.success == 1 ? 'fa-check' : 'fa-ban'
                    ]"
                />
                {{ $store.state.notification.success == 1 ? 'Thông báo' : 'Cảnh báo' }}
            </h5>
            {{$store.state.notification.message}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Notification",
    }
</script>
