<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <p class="text-3xl mb-2">Welcome to this CRM application</p>
            <p>Please make your selection:</p>
            <SecondaryButton @click="companiesClick" class="mt-6">
                Companies
            </SecondaryButton>
            <SecondaryButton @click="employeesClick" class="mt-6 ml-3">
                Employees
            </SecondaryButton>
        </div>

    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    export default {
        components: {
            JetApplicationLogo,
            SecondaryButton
        },
        methods: {
            companiesClick: function(){
                location.href="/companies";
            },
            employeesClick: function(){
                location.href="employees";
            }
        }
    }
</script>
