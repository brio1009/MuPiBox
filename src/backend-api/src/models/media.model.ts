import { CategoryType } from './folder.model'

export type MediaType = 'rss' | 'local' | 'radio' | 'spotifyPlaylist' | 'spotifyEpisode'

export interface BaseMedia {
  type: MediaType
  name: string
  category: CategoryType
  folderName: string
  img: string
  allowShuffle: boolean
  shuffle: boolean
}

export interface LocalMedia extends BaseMedia {
  type: 'local'
  allowShuffle: false
  shuffle: false
}

export interface RssMedia extends BaseMedia {
  type: 'rss'
  url: string
  releaseDate: string
  allowShuffle: false
  shuffle: false
}

export interface RadioMedia extends BaseMedia {
  type: 'radio'
  url: string
  allowShuffle: false
  shuffle: false
}

export interface SpotifyPlaylistMedia extends BaseMedia {
  type: 'spotifyPlaylist'
  id: string
  releaseDate: string
  allowShuffle: boolean
  shuffle: boolean
}

export interface SpotifyEpisodeMedia extends BaseMedia {
  type: 'spotifyEpisode'
  id: string
  releaseDate: string
  allowShuffle: boolean
  shuffle: boolean
}

export type Media = RssMedia | RadioMedia | LocalMedia | SpotifyEpisodeMedia | SpotifyPlaylistMedia