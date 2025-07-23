<template>
  <div class="no-results">
    🔍 No policies found for "{{ broker }}"
  </div>
</template>

<script>
export default {
  props: ['broker']
};
</script>
