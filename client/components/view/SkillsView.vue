<template>
  <div class="flex flex-col">
    <div class="text-xl flex flex-row">
      Skills: <div class="cursor-pointer px-4 underline text-sm" @click="dataShowSkillAdd = !dataShowSkillAdd">
        {{ dataShowSkillAdd?'View':'Edit' }} skills
      </div>
    </div>
    <div v-if="dataList && dataList.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-1 py-4">
      <div
        v-for="skill in dataList"
        :key="`skill-${skill.id}`"
        class="flex items-center p-3 bg-white rounded-xl shadow-xs hover:shadow-md transform transition duration-500"
        style="height: 35px;"
        @mouseover="hoverItem(skill.id)"
        @mouseleave="hoverItem(null)"
      >
        <div class="flex-none">{{ skill.name }} <span v-if="skill.years">- {{ skill.years }}yrs</span></div>
        <div class="flex-grow" />
        <div v-if="dataHoverItemId === skill.id && dataShowSkillAdd" class="flex-none">
          <PushButton size="xs" @click="onSkillDelete(skill.id)">
            <icon-minus-circle class="w-4 h-4 mr-1" primary="text-red-300" secondary="text-red-400" />
            Delete
          </PushButton>
        </div>
      </div>
    </div>
    <div v-if="dataShowSkillAdd" class="grid grid-cols-2 gap-4 py-3" style="max-width: 400px;">
      <div class="flex-col flex ">
        <label
          class="form-label block mb-1 font-semibold text-gray-700"
          for="addSkillName"
        >Skill Name</label>
        <input
          id="addSkillName"
          v-model="dataAddSkillName"
          class="px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none"
          type="text"
        >
      </div>
      <div class="flex-col flex">
        <label
          class="form-label block mb-1 font-semibold text-gray-700"
          for="addSkillYears"
        >Skill Years</label>
        <input
          id="addSkillYears"
          v-model="dataAddSkillYears"
          class="px-2 py-2 h-12 leading-normal block w-full text-gray-800 bg-white font-sans rounded-lg text-left appearance-none outline-none"
          type="text"
        >
      </div>
      <PushButton @click="onSkillAdd">
        <icon-plus class="w-5 h-5 mr-2" primary="text-blue-300" secondary="text-blue-400" />
        Add
      </PushButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Maybe } from '@/types/common'
import { ProfileSkill } from '@/types/profile'
import Vue from 'vue'

export default Vue.extend({
  name: 'SkillsView',
  props: {
    profileId: {
      type: Number,
      default: 1,
    },
  },
  data () {
    return {
      dataList: [] as Maybe<ProfileSkill[]>,
      dataAddSkillName: '',
      dataAddSkillYears: 0,
      dataShowSkillAdd: false,
      dataHoverItemId: null as Maybe<number>,
    }
  },
  async mounted () {
    await this.retrieveSkills()
  },
  methods: {
    async retrieveSkills () {
      try {
        this.dataList =
          (await this.$axios.get(`profile/${this.profileId}/skill`)).data as Maybe<ProfileSkill[]>
      } catch (e) {
        // handle error here with a popup or something
        console.log('err', e)
      }
    },
    async onSkillDelete (id: number) {
      try {
        const delResp = await this.$axios.delete(`profile/${this.profileId}/skill/${id}`)
        if (delResp?.data === 1 && Array.isArray(this.dataList)) this.dataList.splice(this.dataList.findIndex(item => item.id === id), 1)
      } catch (e) {
        // handle error here with a popup or something
        console.log('err', e)
      }
    },
    async onSkillAdd () {
      try {
        const addResp = await this.$axios.post(`profile/${this.profileId}/skill`, {
          payload: {
            name: this.dataAddSkillName,
            years: this.dataAddSkillYears,
          },
        })
        if (addResp?.data?.id && Array.isArray(this.dataList)) this.dataList.push(addResp.data)
      } catch (e) {
        // handle error here with a popup or something
      }
    },
    hoverItem (id: Maybe<number>) {
      this.dataHoverItemId = id
    },
  },
})
</script>

<style scoped>

</style>
