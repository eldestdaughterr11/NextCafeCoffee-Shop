import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function PUT(req: NextRequest) {
  try {
    const body = await req.json();
    const { oldName, newName } = body;

    if (!oldName || !newName) {
      return NextResponse.json({ error: 'Missing oldName or newName' }, { status: 400 });
    }

    const update = await prisma.product.updateMany({
      where: { category: oldName },
      data: { category: newName }
    });

    return NextResponse.json({ message: 'Category renamed', count: update.count }, { status: 200 });
  } catch (error) {
    console.error('Rename Category Error:', error);
    return NextResponse.json({ error: 'Failed to rename category.' }, { status: 500 });
  }
}
