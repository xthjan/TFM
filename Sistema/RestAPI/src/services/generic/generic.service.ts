import {
  Injectable,
  InternalServerErrorException,
  Logger,
} from '@nestjs/common';
import { Document, FilterQuery, Model } from 'mongoose';
//import { LoggerService } from 'src/modules/logging/logger.service';

@Injectable()
export abstract class GenericService<T extends Document> {
  public readonly modelName: string;
  public readonly serviceLogger = new Logger(GenericService.name);

  /**
   * The constructor must receive the injected model from the child service in
   * order to provide all the proper base functionality.
   *
   * @param {Model} model - The injected model.
   */
  constructor(
    //logger: LoggerService,
    public readonly model: Model<T>,
  ) {
    for (const modelName of Object.keys(model.collection.conn.models)) {
      if (model.collection.conn.models[modelName] === this.model) {
        this.modelName = modelName;
        break;
      }
    }
  }

  /**
   * Find one entry and return the result.
   *
   * @throws InternalServerErrorException
   */
  async findOne(
    conditions: Record<any, unknown>,
    projection: string | Record<string, unknown> = {},
    options: Record<string, unknown> = {},
  ): Promise<T> {
    try {
      return await this.model.findOne(
        conditions as FilterQuery<T>,
        projection,
        options,
      );
    } catch (err) {
      this.serviceLogger.error(`Could not find ${this.modelName} entry:`);
      this.serviceLogger.error(err);
      throw new InternalServerErrorException();
    }
  }

  async getall(): Promise<T[]> {
    try {
      return await this.model.find();
    } catch (err) {
      this.serviceLogger.error(`Could not find ${this.modelName} entry:`);
      this.serviceLogger.error(err);
      throw new InternalServerErrorException();
    }
  }

  async CreateRecord(item: Partial<Record<keyof T, unknown>>): Promise<T> {
    try {
      const record = this.model.create(item);
      (await record).save();
      return record;
    } catch (err) {
      this.serviceLogger.error(`Could not find ${this.modelName} entry:`);
      this.serviceLogger.error(err);
      console.log(err);
      throw new InternalServerErrorException();
    }
  }
}
