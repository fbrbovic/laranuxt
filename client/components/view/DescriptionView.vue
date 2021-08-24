<template>
  <div class="flex flex-col">
    <div class="text-xl flex flex-row">
      About: <div class="cursor-pointer px-4 underline text-sm" @click="dataShowEdit = !dataShowEdit">
        {{ dataShowEdit?'View':'Edit' }} Description
      </div>
    </div>
    <div v-if="dataShowEdit" class="flex-col flex ">
      <label
        class="form-label block mb-1 font-semibold text-gray-700"
        for="addSkillName"
      >Edit Description</label>
      <input
        id="addSkillName"
        v-model="dataProfile.description"
        class="px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none"
        type="text"
      >
      <div class="flex flex-center">
        <PushButton class="my-4 flex-grow-0" @click="onEditSubmit">
          Update
        </PushButton>
      </div>
    </div>
    <div v-else class="flex-col flex">
      {{ dataProfile.description }}
    </div>
  </div>
</template>

<script lang="ts">
import { Profile } from '@/types/profile'
import Vue from 'vue'

export default Vue.extend({
  name: 'DescriptionView',
  props: {
    value: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      dataProfile: {
        name: undefined,
        description: undefined,
        id: undefined,
        created_at: undefined,
        updated_at: undefined,
      } as Profile,
      dataShowEdit: false,
    }
  },
  watch: {
    value: {
      immediate: true,
      handler (newVal: Profile) {
        this.populateProfile(newVal)
      },
    },
  },
  async mounted () {
  },
  methods: {
    populateProfile (profile: Profile) {
      Object.assign(this.dataProfile, profile)
    },
    async onEditSubmit () {
      try {
        const addResp = await this.$axios.put(`profile/${this.dataProfile.id}`, {
          payload: {
            description: this.dataProfile?.description,
          },
        })
        if (addResp?.data?.id) {
          this.populateProfile(addResp?.data)
          this.$emit('input', addResp.data)
        }
      } catch (e) {
        // handle error here with a popup or something
      }
    },
  },
})
</script>

<style scoped>

</style>
