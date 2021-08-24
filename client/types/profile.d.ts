export interface Profile {
  id?: number
  name?: string
  description?: string
  created_at?: string
  updated_at?: string
}

export interface ProfileSkill {
  id?: number
  name?: string
  years?: number
  profile_id?: number
  created_at?: string
  updated_at?: string
}
