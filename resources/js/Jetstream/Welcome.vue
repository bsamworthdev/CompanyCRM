<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to Company CRM
            </div>
            <p>Please make your selection:</p>
            <SecondaryButton @click="companiesClick" class="mt-6">
                Companies
            </SecondaryButton>
            <SecondaryButton @click="employeesClick" class="mt-6 ml-3">
                Employees
            </SecondaryButton>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            
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
