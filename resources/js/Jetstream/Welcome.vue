<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <p class="text-3xl mb-2">Welcome to this CRM application</p>
            <p>Please make your selection:</p>
            <SecondaryButton @click="companiesClick" class="mt-6 text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Companies
            </SecondaryButton>
            <SecondaryButton @click="employeesClick" class="mt-6 ml-3 text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
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
