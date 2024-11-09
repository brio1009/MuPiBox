import {
  CUSTOM_ELEMENTS_SCHEMA,
  ChangeDetectionStrategy,
  Component,
  WritableSignal,
  input,
  output,
  signal,
} from '@angular/core'

import { AsyncPipe } from '@angular/common'
import { Observable } from 'rxjs'
import { PlayerService } from '../player.service'

export interface SwiperData<T> {
  name: string
  imgSrc: Observable<string>
  data: T
}

@Component({
  selector: 'mupi-swiper',
  templateUrl: './swiper.component.html',
  styleUrls: ['./swiper.component.scss'],
  imports: [AsyncPipe],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  standalone: true,
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SwiperComponent<T> {
  public data = input.required<SwiperData<T>[]>()
  public roundImages = input<boolean>(false)
  public elementClicked = output<SwiperData<T>>()

  protected pageIsShown: WritableSignal<boolean> = signal(false)

  public constructor(private playerService: PlayerService) {}

  public ionViewWillEnter(): void {
    this.pageIsShown.set(true)
  }

  public ionViewWillLeave(): void {
    this.pageIsShown.set(false)
  }

  protected readText(text: string): void {
    this.playerService.sayText(text)
  }
}
