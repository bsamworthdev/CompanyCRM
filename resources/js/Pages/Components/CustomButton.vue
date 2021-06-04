<template>
    <input type="button" :class="['bg-' + color + '-500', 'hover:bg-' + color + '-700', 'text-white', 'font-bold', 'py-' + padding, 'px-' + padding, 'border', 'border-' + color + '-700', 'rounded', 'mr-1', 'mt-1', 'cursor-pointer']" :value="value" />                          
</template>

<script>
  export default {
    props: ['value','padding','color']
  }
</script>