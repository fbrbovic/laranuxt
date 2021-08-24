<template>
  <div v-if="dataProfile" class="container p-2 lg:p-8 flex flex-col">
    <div class="flex items-center p-6 space-x-6 bg-white rounded-xl shadow-sm">
      <div class="text-2xl flex flex-row">{{ dataProfile.name }}</div>
    </div>
    <description-view v-model="dataProfile" class="py-6" />
    <skills-view :profile-id="1" class="py-6" />
  </div>
  <div v-else>
    Could not retrieve the profile
  </div>
</template>

<script lang="ts">
import { Profile } from '@/types/profile'
import { Maybe } from '@/types/common'
import SkillsView from '@/components/view/SkillsView.vue'
import DescriptionView from '@/components/view/DescriptionView.vue'
import Vue from 'vue'

export default Vue.extend({
  components: {
    SkillsView,
    DescriptionView,
  },
  data () {
    return {
      dataProfile: null as Maybe<Profile>,
    }
  },
  async mounted () {
    await this.processProfileData()
  },
  methods: {
    async processProfileData (): Promise<void> {
      try {
        this.dataProfile =
            (await this.$axios.get('profile/1')).data as Maybe<Profile>
      } catch (e) {
        // handle error here with a popup or something
      }
    },
  },
})
</script>

<style scoped>

</style>
